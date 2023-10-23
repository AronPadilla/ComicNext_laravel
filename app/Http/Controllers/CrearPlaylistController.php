<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CrearPlaylistController extends Controller
{
    public function registro(Request $request)
    {
        DB::beginTransaction();
        try {
            $imagen_playlist = $request->imagen_playlist;
            $playlist = new Playlist();
            $playlist->nombre_playlist = $request->nombre_playlist;
            $playlist->cod_usuario = $request->input('cod_usuario'); // Asegúrate de que 'cod_usuario' se envía desde la solicitud.
            $playlist->imagen_playlist = $request->input('imagen_playlist');
            var_dump("inicio imagen");
            if ($imagen_playlist !== null) {
                // Almacenar la imagen directamente en el modelo
                $playlist->imagen_playlist = str_replace("''", "'", pg_escape_bytea(base64_decode($imagen_playlist)));
            } else {
                // Si imagen_playlist es nulo, asignar null al campo imagen_playlist en el modelo
                $playlist->imagen_playlist = null;
            }

            $playlist->save();
            DB::commit();
            return response()->json(['mensaje' => 'Playlist registrado con éxito']);
        } catch (\Exception $e) {
             DB::rollback();
            return response()->json(['error' => 'Error al guardar la playlist: ' . $e->getMessage()], 500);
        }
    }

    function getPlaylist($idUsuario)
    {
        $playlists = Playlist::where('cod_usuario', '=', $idUsuario)
                    ->select('cod_playlist', 'nombre_playlist')
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

    public function Images($playlistId)
    {
        $playlist = DB::table('playlist')
        ->where('cod_playlist', $playlistId)
        ->first();

        if (!$playlist || !$playlist->imagen_playlist) {
            return response()->json(['error' => 'Playlist o portada no encontrados'], 404);
        }

        $contenidoPortada = stream_get_contents($playlist->imagen_playlist);

        return Response::make($contenidoPortada, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    }

}