<?php

namespace App\Http\Controllers;

use App\Models\comic;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'titulo' => 'required|string|max:60',
            'autor' => 'nullable|string|max:100',
            'sinopsis' => 'nullable|string|max:500',
            'anio_publicacion' => 'nullable|integer',
            'portada' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Máximo 2MB4
            
        ]);

        // Almacenar la imagen en el sistema de archivos local
        // $portadaPath = $request->file('portada')->store('portadas', 'public');
        $file = $request->file('portada');
        // $file_path = $file->getRealPath();
        // $file_name = $file->getClientOriginalName();
        // Crear un nuevo cómic en la base de datos
        comic::create([
            'titulo' => $request->input('titulo'),
            'autor' => $request->input('autor'),
            'sinopsis' => $request->input('sinopsis'),
            'anio_publicacion' => $request -> input('anio_publicacion'),
            'portada' => pg_escape_bytea(file_get_contents($file))
            // 'portada' => pg_read_binary_file($file)
        ]);

        return view('Registro'); 
    }
}
