<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ComicController extends Controller
{
    public function comicsXCategoria(Request $request, $nombreCategoria)
    {
        $categoria = DB::table('categoria')->where('categoria', $nombreCategoria)->first();
        
        if (!$categoria) {
            // Maneja el caso en el que la categoría no se encuentra.
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        
        $comics = DB::table('comic_categoria')
            ->join('comic', 'comic_categoria.cod_comic', '=', 'comic.cod_comic')
            ->where('comic_categoria.cod_categoria', $categoria->cod_categoria)
            ->select('comic.*')
            ->get();

        return response()->json($comics);
    }
}
