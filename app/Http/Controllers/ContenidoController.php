<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\comic;
use App\Models\Contenido;
use Illuminate\Support\Facades\DB;

class ContenidoController extends Controller
{
    public function comicsSinContenido(Request $request)
    {
        $comicsSinContenido = DB::table('comic')
        ->whereNotIn('cod_comic', function ($query) {
            $query->select('cod_comic')->from('contenido');
        })
        ->select('comic.cod_comic', 'comic.titulo', 'comic.autor')
        ->get();

        $comicsConPortada = [];
    
        foreach ($comicsSinContenido as $comic) {
             $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
    
             // Agregar el cómic y su URL de portada al arreglo
             $comicsConPortada[] = [
                 'comic' => $comic,
                 'portadaUrl' => $portadaUrl,
             ];
        }
    
        return response()->json($comicsConPortada);
    }
    
    public function registrarContenido(Request $request){

        DB::beginTransaction();
        try{
            $imagenes = $request->imagenes;
            $i = 1;
            foreach($imagenes as $imagen){
                $contenido = new Contenido();
                $contenido->cod_comic = $request->cod_comic;
                $contenido->nro_pagina = $request->pag;
                $contenido->pagina = str_replace("''", "'", pg_escape_bytea(base64_decode($imagen)));
                $contenido->save();
                $i++;
            }
           
            DB::commit();
            return response()->json(['mensaje' => 'Contenido de cómic registrado con éxito']);

        } catch (\Exception $e) {
            DB::rollback();
           return response()->json(['error' => 'Error al guardar la playlist: ' . $e->getMessage()], 500);
       }
        
    }
}
