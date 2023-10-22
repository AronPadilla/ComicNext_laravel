<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrearPlaylistController extends Controller
{
        public function registro(Request $request)
    {
        DB::beginTransaction();
        try {
            $imagen_playlist = $request->imagen_playlist;
            $playlist = new Playlist();
            $playlist->nombre_playlist = $request->nombre_playlist;
            $playlist->cod_usuario = $request->input('cod_usuario'); // Asegúrate de que 'cod_usuario' se envía desde la solicitud.
            $playlist->imagen_playlist = $request->input('imagen_playlist');
            var_dump("inicio imagen");
            if ($imagen_playlist !== null) {
                // Almacenar la imagen directamente en el modelo
                $playlist->imagen_playlist = str_replace("''", "'", pg_escape_bytea(base64_decode($imagen_playlist)));
            } else {
                // Si imagen_playlist es nulo, asignar null al campo imagen_playlist en el modelo
                $playlist->imagen_playlist = null;
            }

            $playlist->save();
            DB::commit();
            return response()->json(['mensaje' => 'Playlist registrado con éxito']);
        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => 'Error al guardar la playlist: ' . $e->getMessage()], 500);
        }
    }
}