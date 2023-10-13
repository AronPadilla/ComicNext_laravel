<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\comic;
use App\Models\Comic_categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function register(Request $request)
    {
        // $titulo = $request->input('titulo');
        // $autor = $request->input('autor');
        // $anioPublicacion = $request->input('anio_publicacion');
        // $sinopsis = $request->input('sinopsis');
        $portada = $request->portada;

        DB::beginTransaction(); // Iniciar una transacción en la base de datos

        try {
            // Registrar el cómic
            $comic = new Comic();
            $comic->titulo = $request -> titulo;
            $comic->autor = $request -> autor;
            $comic->anio_publicacion = $request -> anio_publicacion;
            $comic->sinopsis = $request -> sinopsis;
            // var_dump($portada);
            $comic->portada =  pg_escape_bytea(base64_decode($portada));
            // var_dump($portada);
            $comic->save();

            // Obtener el ID del cómic registrado
            $codigoComic = $comic->cod_comic;
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

            DB::commit(); // Confirmar la transacción si todo se realizó con éxito

            return response()->json(['mensaje' => 'Cómic registrado con éxito']);
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}