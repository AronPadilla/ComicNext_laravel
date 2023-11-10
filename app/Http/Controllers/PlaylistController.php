<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Playlist;
use App\Models\Comic_playlist;

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
    function datosPlaylist(Request $request, $idUsuario, $idPlaylist){
        $playlist = DB::table('playlist')
        ->where('cod_playlist', $idPlaylist)
        ->where('cod_usuario',  $idUsuario)
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

    public function updatePlaylist(Request $request){
        DB::beginTransaction();
        try {
            $imagen_playlist = $request->imagen_playlist;
            $playlist = Playlist::find($request->cod_playlist);
            $playlist->nombre_playlist = $request->nombre_playlist;
            $playlist->imagen_playlist = str_replace("''", "'", pg_escape_bytea(base64_decode($imagen_playlist)));
            // $playlist->imagen_playlist = $request->input('imagen_playlist');
            // var_dump("inicio imagen");
            // if ($imagen_playlist !== null) {
            //     // Almacenar la imagen directamente en el modelo
            //     $playlist->imagen_playlist = str_replace("''", "'", pg_escape_bytea(base64_decode($imagen_playlist)));
            // } else {
            //     // Si imagen_playlist es nulo, asignar null al campo imagen_playlist en el modelo
            //     $playlist->imagen_playlist = null;
            // }
            $playlist->update();
            DB::commit();
            return response()->json(['mensaje' => 'Playlist actualizado con éxito']);
        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => 'Error al guardar cambios de la playlist: ' . $e->getMessage()], 500);
        }
    }

    public function eliminarPlaylist(Request $request){
        try{
            $playlist = Playlist::find($request->cod_playlist);
            if ($playlist) {
                $playlist->delete();
                Comic_playlist::where('cod_playlist', $request->cod_playlist)->delete();
                return response()->json(['mensaje' => 'Playlist eliminada con éxito']);
            } 
        }catch (\Exception $e) {
            DB::rollback();
           return response()->json(['error' => 'Error al eliminar la playlist: ' . $e->getMessage()], 500);
       }
    }
}
