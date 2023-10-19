<?php

use App\Http\Controllers\RegistroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ListComicController;
use App\Http\Controllers\PlaylistController;

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
    Route::get('/comic/{id}', 'comicsXCategoria');
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


