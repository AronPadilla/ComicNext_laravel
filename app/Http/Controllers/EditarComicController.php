<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\comic; // Suponiendo que tienes un modelo Comic
use App\Models\Comic_categoria;

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
        $portada = $request->portada;
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
            'portada' => str_replace("''", "'", pg_escape_bytea(base64_decode($portada))),
            // Maneja las categorías según la estructura de tu base de datos
        ]);

        // Eliminar todas las ctegorias el cómic por ID
        $cats = Comic_categoria::where('cod_comic', $id)->delete();

        // Obtener el ID del cómic registrado
        $codigoComic = $id;
        $categorias = $request->categoria;
        $codCategorias = array(); 

        foreach ($categorias as $categoria) {
            switch ($categoria) {
                case "Terror":
                    $codCategorias[] = 1; 
                    break;
                case "CienciaFiccion":
                    $codCategorias[] = 3;
                    break;
                case "Comedia":
                    $codCategorias[] = 4;
                    break;
                case "Accion":
                    $codCategorias[] = 2;
                    break;
                default:
                    echo "Opción no válida";
                    break;
            }
        }

// Ahora $codCategorias contiene los códigos numéricos correspondientes a las categorías.

        
        // $codigosCategoria = $request->input('codigosCategoria');

        if (is_array($codCategorias)) {
             foreach ($codCategorias as $codCategoria) {
                 // Asociar el cómic con las categorías seleccionadas
                 Comic_categoria::create([
                     'cod_comic' => $codigoComic,
                     'cod_categoria' => $codCategoria,
                ]);
            }
        } else {
             // Manejar un error si $codigosCategoria no es un array
             throw new \Exception('Los códigos de categoría no son válidos.');
         }

        return response()->json(['message' => 'Cómic editado exitosamente']);
    }

  
    
}
