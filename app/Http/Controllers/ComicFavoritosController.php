<?php

namespace App\Http\Controllers;
use App\Models\Me_gusta;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ComicFavoritosController extends Controller
{
    public function registroComicFavoritos(Request $request)
    {
    
        DB::beginTransaction();
    
        try {
            // Crea una nueva instancia del modelo Me_gusta y asigna los valores
            $comic_favoritos = new Me_gusta();
            $comic_favoritos->cod_comic = $request->cod_comic;
            $comic_favoritos->cod_usuario = $request->cod_usuario;
            $comic_favoritos->fecha_creacion = now();
            
            $comic_favoritos->save();
    
            DB::commit();
    
            return response()->json(['mensaje' => 'Cómic registrado a playlist con éxito'], 200);
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
