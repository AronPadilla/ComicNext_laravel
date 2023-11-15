<?php

namespace App\Http\Controllers;
use App\Models\Me_gusta;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class ComicFavoritosController extends Controller
{
    public function registroComicFavoritosLike(Request $request)
    {
        DB::beginTransaction();

        try {
            // Busca si ya existe una entrada en la lista de favoritos para el cómic y usuario especificados
            $comic_favoritos = Me_gusta::where('cod_comic', $request->cod_comic)
                                    ->where('cod_usuario', $request->cod_usuario)
                                    ->get();

            if (count($comic_favoritos) ) {
                // Si ya existe una entrada, elimínala (quitar de favoritos)
                Me_gusta::where('cod_comic', $request->cod_comic)
                        ->where('cod_usuario', $request->cod_usuario)
                        ->delete();
                DB::commit();
                return response()->json(['mensaje' => 'Comic eliminado'], 200);
            } else {
                // Si no existe una entrada, crea una nueva (agregar a favoritos)
                $nuevoComicFavorito = new Me_gusta();
                $nuevoComicFavorito->cod_comic = $request->cod_comic;
                $nuevoComicFavorito->cod_usuario = $request->cod_usuario;
                $nuevoComicFavorito->fecha_creacion = now();
                $nuevoComicFavorito->save();
                DB::commit();
                return response()->json(['mensaje' => 'Cómic añadido a la lista de favoritos con éxito'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback(); // Revertir la transacción en caso de error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function obtenerComicFavoritos (Request $request, $cod_usuario){
        $comicsFavortitos = DB::table('me_gusta')
            ->join('comic', 'me_gusta.cod_comic', '=', 'comic.cod_comic')
            ->where('cod_usuario', $cod_usuario)
            ->orderByDesc('fecha_creacion')
            ->select('comic.cod_comic', 'comic.titulo', 'comic.sinopsis', 'comic.anio_publicacion', 'comic.autor')
            ->get();
            $comicsConPortada = [];
            $comic_favoritos = count($comicsFavortitos);
            foreach ($comicsFavortitos as $comic) {
                $portadaUrl = route('getPortada', ['comicId' => $comic->cod_comic]);
        
                // Agregar el cómic y su URL de portada al arreglo
                $comicsConPortada[] = [
                    'comic' => $comic,
                    'portadaUrl' => $portadaUrl,
                    'comic_favoritos' => boolval($comic_favoritos), 
                ];
            }
        
            return response()->json($comicsConPortada);
        }
        
    
        public function getPortadaC($comicId)
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
}
