<?php

namespace App\Http\Controllers;

use App\Models\comic; // Agrega un punto y coma al final de esta línea
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class ListComicController extends Controller
{
    function listasComic(){
        $comics = Comic::select('cod_comic', 'titulo','sinopsis', 'anio_publicacion', 'autor')->orderBy('titulo')->get();
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
    public function obtenerPortada($comicId)
    {
        $comic = DB::table('comic')->where('cod_comic', $comicId)->first();

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

   
}
