<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Comic_playlist;

class ComicPlaylistController extends Controller
{
    public function registrarComicAPlaylist(Request $request)
    {
        //
        DB::beginTransaction(); // Iniciar una transacción en la base de datos

        try {
            // Registrar el cómic
            $comicPlaylist = new Comic_playlist();
            $comicPlaylist->cod_comic = $request -> cod_comic;
            $comicPlaylist->cod_usuario = $request -> cod_uduario;
            $comicPlaylist->cod_playlist = $request -> cod_playlist;
           
            $comicPlaylist->save();

            DB::commit(); // Confirmar la transacción si todo se realizó con éxito

            return response()->json(['mensaje' => 'Cómic registrado a playlist con éxito']);

        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
