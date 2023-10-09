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
            $comic->portada = str_replace("''", "'", pg_escape_bytea(base64_decode($portada)));
            // var_dump($portada);
            $comic->save();

            // Obtener el ID del cómic registrado
            $codigoComic = $comic->cod_comic;

            // $codigosCategoria = $request->input('codigosCategoria');

            // if (is_array($codigosCategoria)) {
            //     foreach ($codigosCategoria as $codCategoria) {
            //         // Asociar el cómic con las categorías seleccionadas
            //         Comic_categoria::create([
            //             'cod_comic' => $codigoComic,
            //             'cod_categoria' => $codCategoria,
            //         ]);
            //     }
            // } else {
            //     // Manejar un error si $codigosCategoria no es un array
            //     throw new \Exception('Los códigos de categoría no son válidos.');
            // }

            DB::commit(); // Confirmar la transacción si todo se realizó con éxito

            return response()->json(['mensaje' => 'Cómic registrado con éxito']);
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}