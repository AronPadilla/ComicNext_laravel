<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic; // Suponiendo que tienes un modelo Comic

class EditarComicController extends Controller
{
    public function editarComic(Request $request, $id)
    {
        // Valida los datos de la solicitud entrante
        $request->validate([
            'titulo' => 'required|string|max:80',
            'autor' => 'nullable|string|max:100',
            'sinopsis' => 'required|string|max:500',
            'anio_publicacion' => 'nullable|date',
            'portada' => 'nullable|string', // Puedes validar el formato de la imagen aquí
            'categoria' => 'required|array',
        ]);

        // Busca el cómic por ID
        $comic = Comic::find($id);
        if (!$comic) {
            return response()->json(['error' => 'Cómic no encontrado'], 404);
        }

        // Actualiza todos los campos
        $comic->update([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'sinopsis' => $request->sinopsis,
            'anio_publicacion' => $request->anio_publicacion,
            'portada' => $request->portada,
            // Maneja las categorías según la estructura de tu base de datos
        ]);

        return response()->json(['message' => 'Cómic editado exitosamente']);
    }
}
