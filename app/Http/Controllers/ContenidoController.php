<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\comic;
use Illuminate\Support\Facades\DB;

class ContenidoController extends Controller
{
    public function comicsSinContenido(Request $request)
    {
        $comicsSinContenido = DB::table('comic')
        ->whereNotIn('cod_comic', function ($query) {
            $query->select('cod_comic')->from('contenido');
        })
        ->select('comic.cod_comic', 'comic.titulo', 'comic.sinopsis')
        ->get();

        $comicsConPortada = [];
    
        foreach ($comicsSinContenido as $comic) {
             $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
    
             // Agregar el cómic y su URL de portada al arreglo
             $comicsConPortada[] = [
                 'comic' => $comic,
                 'portadaUrl' => $portadaUrl,
             ];
        }
    
        return response()->json($comicsConPortada);
    }
}
