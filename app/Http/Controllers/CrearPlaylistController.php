<?php

namespace App\Http\Controllers;
use App\Models\Playlist;
use Illuminate\Http\Request;

class CrearPlaylistController extends Controller
{
    public function registro(Request $request){
        $imagen_playlist = $request->imagen_playlist;
        $playlist = new Playlist();
        $playlist ->nombre_playlist = $request -> titulo;
        $playlist ->imagen_playlist = str_replace("''", "'", pg_escape_bytea(base64_decode($imagen_playlist))); 
        $playlist ->save();
        return response()->json(['mensaje' => 'Playlist registrado con éxito']);
    }
    
}