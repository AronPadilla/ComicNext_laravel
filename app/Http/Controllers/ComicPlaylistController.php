<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Comic_playlist;

class ComicPlaylistController extends Controller
{
    public function registrarComicAPlaylist(Request $request)
    {
        //
        DB::beginTransaction(); // Iniciar una transacción en la base de datos

        try {
            // Registrar el cómic
            $creacionTime = now();
            
            $comicPlaylist = new Comic_playlist();
            $comicPlaylist->cod_comic = $request->cod_comic;
            $comicPlaylist->cod_usuario = $request->cod_usuario;
            $comicPlaylist->cod_playlist = $request->cod_playlist;
            $comicPlaylist->creacion_time = $creacionTime;
           
            $comicPlaylist->save();

            DB::commit(); // Confirmar la transacción si todo se realizó con éxito

            return response()->json(['mensaje' => 'Cómic registrado a playlist con éxito']);

        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function comicRegistrado(Request $request,$cod_usuario,$cod_comic,$cod_playlist){
        $comic = DB::table('comic_playlist')
        ->where('cod_comic', $cod_comic)
        ->where('cod_usuario', $cod_usuario)
        ->where('cod_playlist', $cod_playlist)
        ->first();
        if (!$comic){
            return response()->json(['exists' => false]);
        }else{
            return response()->json(['exists' => true]);
        }
    }

     public function obtenerComicsPlaylist(Request $request,  $cod_usuario,$cod_playlist){
        $comics = DB::table('comic_playlist')
        ->join('comic', 'comic_playlist.cod_comic', '=', 'comic.cod_comic')
        ->where('cod_usuario', $cod_usuario)
        ->where('cod_playlist', $cod_playlist)
        ->select('comic.cod_comic', 'comic.titulo', 'comic.sinopsis', 'comic.anio_publicacion', 'comic.autor')
        ->orderBy('creacion_time')
        ->get();
        // $comics = $comics;
        $comicsConPortada = [];
    
        foreach ($comics as $comic) {
            $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
    
            // Agregar el cómic y su URL de portada al arreglo
            $comicsConPortada[] = [
                'comic' => $comic,
                'portadaUrl' => $portadaUrl,
            ];
        }
    
        return response()->json($comicsConPortada);
    }
    

    public function getPortadaC(Request $request, $comicId)
    {
        $comic = DB::table('comic')
        ->where('cod_comic', $comicId)
        ->first();

        if (!$comic || !$comic->portada) {
            return response()->json(['error' => 'Cómic o portada no encontrados'], 404);
        }

        $contenidoPortada = stream_get_contents($comic->portada);

        return Response::make($contenidoPortada, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

    public function obtenerComicsPlaylistTitulo(Request $request, $cod_usuario, $cod_playlist){
        $comics = DB::table('comic_playlist')
        ->join('comic', 'comic_playlist.cod_comic', '=', 'comic.cod_comic')
        ->where('cod_usuario', $cod_usuario)
        ->where('cod_playlist', $cod_playlist)
        ->select('comic.cod_comic', 'comic.titulo', 'comic.sinopsis', 'comic.anio_publicacion', 'comic.autor')
        ->orderBy('comic.titulo')
        ->get();

        $comicsConPortada = [];
    
        foreach ($comics as $comic) {
            $portadaUrl = route('getPortadaC', ['comicId' => $comic->cod_comic]);
    
            // Agregar el cómic y su URL de portada al arreglo
            $comicsConPortada[] = [
                'comic' => $comic,
                'portadaUrl' => $portadaUrl,
            ];
        }
    
        return response()->json($comicsConPortada);
    }
    public function destroy(Request $request)
    {
        $cod_comic = $request->input('cod_comic');
        $cod_usuario = $request->input('cod_usuario');
        $cod_playlist = $request->input('cod_playlist');

        $deletedRows = Comic_playlist::where([
            ['cod_comic', '=', $cod_comic],
            ['cod_usuario', '=', $cod_usuario],
            ['cod_playlist', '=', $cod_playlist]
        ])->delete();

        if ($deletedRows > 0) {
            return response()->json(['message' => 'Eliminado exitosamente'], 200);
        } else {
            return response()->json(['message' => 'No se encontraron registros para eliminar'], 404);
        }
    } 
}
