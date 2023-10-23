<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\comic;

class BuscarController extends Controller
{
    public function comicFiltrar(Request $request, $nombreComic)
    {
        $comics = DB::table('comic')
            ->select('cod_comic', 'titulo', 'sinopsis')
            ->where('titulo', 'LIKE', '%'.$nombreComic.'%')
            ->orderBy('comic.titulo')
            ->get();
        
        if (!$comics) {
            // Maneja el caso en que la categoría no se encuentra.
            return response()->json(['error' => 'Comic no encontrada'], 404);
        }
            // Crear un arreglo para almacenar los cómics y sus URLs de portada
        $comicsConPortada = [];
    
        foreach ($comics as $comic) {
            $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
    
            // Agregar el cómic y su URL de portada al arreglo
            $comicsConPortada[] = [
                'comic' => $comic,
                'portadaUrl' => $portadaUrl,
            ];
        }
    
        return response()->json($comicsConPortada);
    }
    

    public function getPortada(Request $request, $comicId)
    {
        $comic = DB::table('comic')
        ->where('cod_comic', $comicId)
        ->first();

        if (!$comic || !$comic->portada) {
            // Maneja el caso en el que el cómic o la portada no se encuentren.
            return response()->json(['error' => 'Cómic o portada no encontrados'], 404);
        }

        // Leer el contenido binario de la portada como una cadena de bytes
        $contenidoPortada = stream_get_contents($comic->portada);

        // Devolver la imagen de portada como una respuesta HTTP con el tipo de contenido adecuado
        return Response::make($contenidoPortada, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

    public function comic($id)
    {
        $comic = Comic::select('cod_comic', 'titulo','sinopsis', 'anio_publicacion', 'autor')
            ->where('cod_comic', $id)
            ->first();
        if (!$comic) {
            return response()->json(['error' => 'Cómic no encontrado'], 404);
        }
    
        $comicsConPortada = [];
    
        
        $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
    
        // Agregar el cómic y su URL de portada al arreglo
        $comicsConPortada[] = [
           'comic' => $comic,
            'portadaUrl' => $portadaUrl,
        ];
    
        return response()->json($comicsConPortada);
    }
}
