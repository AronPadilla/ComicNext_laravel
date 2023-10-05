<?php

namespace App\Http\Controllers;

use App\Models\comic; // Agrega un punto y coma al final de esta línea

use Illuminate\Http\Request;

class ListComicController extends Controller
{
    
    public function index()
    {

        // $comic = comic::all(); // Corrige el nombre de la variable a $comics
        $comics = Comic::select('cod_comic', 'titulo', 'autor', 'sinopsis', 'anio_publicacion','portada')->get();
        foreach($comics as $comic){
            $type = 'png';
            $data = stream_get_contents($comic->portada);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $comic->portada = $base64;
        }
        
        return response()->json($comics);
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
