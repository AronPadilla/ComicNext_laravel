<?php

namespace App\Http\Controllers;

use App\Models\comic;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    const MY_CONSTANT = 'value';

    public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'titulo' => 'required|string|max:60',
            'autor' => 'nullable|string|max:100',
            'sinopsis' => 'nullable|string|max:500',
            'anio_publicacion' => 'nullable|integer',
            'portada' => 'required|image', // Máximo 2MB
        ]);

        // Almacenar la imagen en el sistema de archivos local
        // $portadaPath = $request->file('portada')->store('portadas', 'public');
        $file = $request->file('portada');
        // $file_path = $file->getRealPath();
        // $file_name = $file->getClientOriginalName();
        // Crear un nuevo cómic en la base de datos
        Comic::create([
            'titulo' => $request->input('titulo'),
            'autor' => $request->input('autor'),
            'sinopsis' => $request->input('sinopsis'),
            'anio_publicacion' => $request -> input('anio_publicacion'),
            'portada' => str_replace("''", "'", pg_escape_bytea(file_get_contents($file)))
        ]);

        return view('welcome'); 
    } 
}
