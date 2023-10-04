<?php

namespace App\Http\Controllers;

use App\Models\comic; // Agrega un punto y coma al final de esta línea

use Illuminate\Http\Request;

class ListComicController extends Controller
{
    
    public function index()
    {
        // $comic = comic::all(); // Corrige el nombre de la variable a $comics
        $comic = Comic::select('cod_comic', 'titulo', 'autor', 'sinopsis', 'anio_publicacion')->get();

        return response()->json($comic);
    }

    function images($id){
        $file =comic::find($id); 
        // dump($file->image);
        $name = 'test.png';
        // $name = $file->titulo;
        file_put_contents($name , stream_get_contents($file->portada));
        $headers = array(
            // "Content-Type: {$file->mime}",
            "Content-Type: d",
        );
        return response()->download($name, $name, $headers)->deleteFileAfterSend(true);
    }

   
}
