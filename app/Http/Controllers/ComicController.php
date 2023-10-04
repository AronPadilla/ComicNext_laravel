<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\comic;

class ComicController extends Controller
{
    public function comicsXCategoria(Request $request, $nombreCategoria)
    {
        $categoria = DB::table('categoria')->where('categoria', $nombreCategoria)->first();
    
        if (!$categoria) {
            // Maneja el caso en que la categoría no se encuentra.
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        
        $comics = DB::table('comic_categoria')
            ->join('comic', 'comic_categoria.cod_comic', '=', 'comic.cod_comic')
            ->where('comic_categoria.cod_categoria', $categoria->cod_categoria)
            ->select('comic.cod_comic', 'comic.titulo', 'comic.sinopsis')
            ->get();
    
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
    
    public function prueba(Request $request)
    {
        
        $comic = DB::table('imagenes')
        ->select('imagenes.id_img', 'imagenes.nombre_img')
        ->get();

        return response()->json($comic);
    }

    public function getPortada($comicId)
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
    
    public function getImagen($imgId)
    {
        $comic = DB::table('imagenes')->where('id_img', $imgId)->first();

        if (!$comic || !$comic->imagen) {
            // Maneja el caso en el que el cómic o la portada no se encuentren.
            return response()->json(['error' => 'Cómic o portada no encontrados'], 404);
        }
    
        // Leer el contenido binario de la portada como una cadena de bytes
        $contenidoPortada = stream_get_contents($comic->imagen);
    
        // Devolver la imagen de portada como una respuesta HTTP con el tipo de contenido adecuado
        return Response::make($contenidoPortada, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
}
