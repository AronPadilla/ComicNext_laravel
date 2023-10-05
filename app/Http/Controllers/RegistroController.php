<?php
namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Categoria;
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
            'portada' => 'required|image', // Máximo 2MB
            'categorias' => 'required|array', // Debes recibir un array de categorías
        ]);

        // Almacenar la imagen en el sistema de archivos local
        $file = $request->file('portada');
        $portada = str_replace("''", "'", pg_escape_bytea(file_get_contents($file)));

        // Crear un nuevo cómic en la base de datos
        $comic = new Comic([
            'titulo' => $request->input('titulo'),
            'autor' => $request->input('autor'),
            'sinopsis' => $request->input('sinopsis'),
            'anio_publicacion' => $request->input('anio_publicacion'),
            'portada' => $portada,
        ]);

        // Guardar el cómic
        $comic->save();

        // Obtener las categorías seleccionadas desde React
        $categoriasSeleccionadas = $request->input('categorias');

        // Asignar las categorías al cómic
        foreach ($categoriasSeleccionadas as $categoriaId) {
            $categoria = Categoria::find($categoriaId);

            if ($categoria) {
                // Asigna la categoría al cómic
                $comic->categorias()->attach($categoria);
            }
        }

        // Si deseas responder con un mensaje de éxito o redireccionar a otra vista, puedes hacerlo aquí
        return response()->json(['mensaje' => 'Cómic registrado con éxito']);
    }
}
