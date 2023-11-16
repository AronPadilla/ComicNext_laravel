<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\comic;
use App\Models\Comic_categoria;
use App\Models\Me_gusta;
use App\Models\Contenido;


class BuscarController extends Controller
{
    public function getContenido(Request $request, $comicId) {
        $contenido = Contenido::select('nro_pagina')
            ->where('cod_comic', $comicId)
            ->orderBy('nro_pagina', 'asc')
            ->get();
    
        $comicsConPortada = [];

        $comicsConPortada[] = [
            'nro_pagina' => "portada",
            'pagina' => route('getPortada', ['comicId' => $comicId])
        ];
    
        foreach ($contenido as $comic) {

            $comicsConPortada[] = [
                'nro_pagina' => $comic->nro_pagina,
                'pagina' => route('getImage', ['idComic' => $comicId, 'numPag' => $comic->nro_pagina]),

            ];
        }
    
        return response()->json($comicsConPortada);
    }
    
    public function getImage(Request $request,$comicId, $numPag)
    {
        $comic = DB::table('contenido')->where('cod_comic', $comicId)
        ->where('nro_pagina', $numPag)->first();
        
        // Leer el contenido binario de la portada como una cadena de bytes
        $contenidoPortada = stream_get_contents($comic->pagina);

        // Devolver la imagen de portada como una respuesta HTTP con el tipo de contenido adecuado
        return Response::make($contenidoPortada, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

    public function obtener(Request $request)
    {
        
        $comics = Comic::select('cod_comic', 'titulo', 'autor', 'sinopsis', 'anio_publicacion')->orderBy('titulo')->get();
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

    public function comicFiltrar(Request $request, $nombreAutor)
    {
        $comics = Comic::whereRaw("lower(unaccent(titulo)) LIKE ?", [strtolower($nombreAutor) . '%'])
            ->select('cod_comic', 'titulo', 'sinopsis')
            ->orderBy('titulo')
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
    
    

    public function filtrarArtista(Request $request, $nombreAutor)
    {
        $comics = Comic::whereRaw("lower(unaccent(autor)) LIKE ?", [strtolower($nombreAutor) . '%'])
            ->select('cod_comic', 'titulo', 'sinopsis')
            ->orderBy('titulo')
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

    public function filtrarSinopsis(Request $request, $sinopsisIn)
    {
        $comics = Comic::whereRaw("lower(unaccent(sinopsis)) LIKE ?",[ '%' . strtolower($sinopsisIn) . '%'])
            ->select('cod_comic', 'titulo', 'sinopsis')
            ->orderBy('titulo')
            ->get();

    
        if (!$comics) {
            // Maneja el caso en que la categoría no se encuentra.
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        

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

    public function filtrarAnio(Request $request, $anioDeseado)
    {
        $comics = DB::table('comic')
            ->select('cod_comic', 'titulo', 'sinopsis')
            ->whereYear('anio_publicacion', '=', $anioDeseado)
            ->orderBy('titulo')
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

    public function comic(Request $request, $id)
    {
        $comic = Comic::select('cod_comic', 'titulo','sinopsis', 'anio_publicacion', 'autor')
            ->where('cod_comic', $id)
            ->first();
        if (!$comic) {
            return response()->json(['error' => 'Cómic no encontrado'], 404);
        }
    
        $comicsConPortada = [];
        $comic_favoritos = Me_gusta::where('cod_comic', $id)
        ->where('cod_usuario', $request->query('codUsuario'))
        ->get();
        
        $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
        $comic_favoritos = count($comic_favoritos);
        // Agregar el cómic y su URL de portada al arreglo
        $comicsConPortada[] = [
           'comic' => $comic,
            'portadaUrl' => $portadaUrl,    
            'comic_favoritos' => boolval($comic_favoritos), 
        ];
    
        return response()->json($comicsConPortada);
    }
}
