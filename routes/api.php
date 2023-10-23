<?php

use App\Http\Controllers\RegistroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\CrearPlaylistController;
use App\Http\Controllers\ListComicController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ComicPlaylistController;
use App\Http\Controllers\RegistroUsuarioController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comics',[ListComicController::class, 'index']);

Route::controller(ComicController::class)->group(function (){
    Route::get('/categoria/{nombreCategoria}', 'comicsXCategoria');
    Route::get('/prueba', 'prueba');
    Route::get('/portadas/{comicId}', 'getPortada')->name('getPortada');
    Route::get('/imagen/{imgId}', 'getImagen');
    Route::get('/tituloExistente/{titulo}', 'tituloExistente');
    Route::get('/comic/{id}', 'comic');
});

Route::controller(ComicPlaylistController::class)->group(function (){
    //Route::get('/playlists/{idUsuario}', 'obtenerPlaylist');
    Route::get('/comicRegistradoPlaylist/{request}', 'comicRegistrado');
    Route::match(['get', 'post'], '/registroComicPlaylist', 'registrarComicAPlaylist');
});

Route::controller(PlaylistController::class)->group(function (){
    Route::get('/playlists/{idUsuario}', 'obtenerPlaylist');
    Route::get('/portadaPlaylist/{playlistId}', 'getPortadaPlaylist')->name('getPortadaPlaylist');
});
// Route::get('/images/{id}',[ListComicController::class, 'images']);

// Route::get('/images',[ListComicController::class, 'images']);

Route::get('/comics',[ListComicController::class, 'index']);

Route::get('/listascomics',[ListComicController::class, 'listasComic']);


//Route::post('/RegistroComics',[RegistroController::class, 'register']);


// Route::get('/descargar', [ListComicController::class, 'images'])->name('comic.descargar');

//Route::get('/comics/{id}', [ListComicController::class, 'images']);
//Route::get('/json', [ListComicController::class, 'index']);

// Route::post('/register', 'ComicController@register');

//Route::post('/RegistroComics',[RegistroController::class, 'register']);

Route::match(['get', 'post'], '/registro', [RegistroController::class, 'register']);

Route::match(['get', 'post'], '/registroplay', [CrearPlaylistController::class, 'registro']);
//Route::get('/registro-usuario', 'RegistroUsuarioController@index')->name('registro-usuario.index');
//Route::post('/registro-usuario', 'RegistroUsuarioController@registrar')->name('registro-usuario.registrar');
Route::match(['get', 'post'], '/registro-usuario', [RegistroUsuarioController::class, 'registrar']);
