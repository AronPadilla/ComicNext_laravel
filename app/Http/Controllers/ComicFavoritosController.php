<?php

namespace App\Http\Controllers;
use App\Models\Me_gusta;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ComicFavoritosController extends Controller
{
    public function registroComicFavoritosLike(Request $request)
    {
        DB::beginTransaction();

        try {
            // Busca si ya existe una entrada en la lista de favoritos para el cómic y usuario especificados
            $comic_favoritos = Me_gusta::where('cod_comic', $request->cod_comic)
                                    ->where('cod_usuario', $request->cod_usuario)
                                    ->get();

            if (count($comic_favoritos) ) {
                // Si ya existe una entrada, elimínala (quitar de favoritos)
                Me_gusta::where('cod_comic', $request->cod_comic)
                        ->where('cod_usuario', $request->cod_usuario)
                        ->delete();
                DB::commit();
                return response()->json(['mensaje' => 'Comic eliminado'], 200);
            } else {
                // Si no existe una entrada, crea una nueva (agregar a favoritos)
                $nuevoComicFavorito = new Me_gusta();
                $nuevoComicFavorito->cod_comic = $request->cod_comic;
                $nuevoComicFavorito->cod_usuario = $request->cod_usuario;
                $nuevoComicFavorito->fecha_creacion = now();
                $nuevoComicFavorito->save();
                DB::commit();
                return response()->json(['mensaje' => 'Cómic añadido a la lista de favoritos con éxito'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
