<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Playlist;

class PlaylistController extends Controller
{
    function obtenerPlaylist(Request $request, $idUsuario)
    {
        $playlists = DB::table('playlist')
        ->where('cod_usuario', $idUsuario)
        ->select('cod_playlist','nombre_playlist')
        ->get();

        if (!$playlists) {
            // Maneja el caso en que la categoría no se encuentra.
            return response()->json(['error' => 'Playlists no encontradas'], 404);
        }

        $playlistConPortada = [];

        foreach ($playlists as $playlist) {
            $portadaUrl = route('getPortadaPlaylist', ['playlistId' => $playlist->cod_playlist]);
    
            // Agregar el cómic y su URL de portada al arreglo
            $playlistConPortada[] = [
                'playlist' => $playlist,
                'portadaUrl' => $portadaUrl,
            ];
        }
    
        return response()->json($playlistConPortada);
    }

    public function getPortadaPlaylist(Request $request, $playlistId)
    {
        $playlist = DB::table('playlist')
        ->where('cod_playlist', $playlistId)
        ->first();

        if (!$playlist || !$playlist->imagen_playlist) {
            // Maneja el caso en el que el cómic o la portada no se encuentren.
            return response()->json(['error' => 'Playlist o portada no encontrados'], 404);
        }

        // Leer el contenido binario de la portada como una cadena de bytes
        $contenidoPortada = stream_get_contents($playlist->imagen_playlist);

        // Devolver la imagen de portada como una respuesta HTTP con el tipo de contenido adecuado
        return Response::make($contenidoPortada, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }
    function datosPlaylist($idPlaylist){
        $playlist = DB::table('playlist')
        ->where('cod_playlist', $idPlaylist)
        ->select('cod_playlist','nombre_playlist')
        ->first();

        $playlistConPortada = [];

        $portadaUrl = route('getPortadaPlaylist', ['playlistId' => $playlist->cod_playlist]);

        $playlistConPortada[] = [
            'playlist' => $playlist,
            'portadaUrl' => $portadaUrl,
        ];
        return response()->json($playlistConPortada);
    }
}
