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
use App\Http\Controllers\BuscarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContenidoController;
use App\Models\Contenido;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComicFavoritosController;
use App\Http\Controllers\ListfavoritosController;
use App\Http\Controllers\ResetPasswordController;

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
    Route::get('/comicRegistradoPlaylist/{cod_usuario}/{cod_comic}/{cod_playlist}', 'comicRegistrado');
    Route::match(['get', 'post'], '/registroComicPlaylist', 'registrarComicAPlaylist');
    Route::get('/comicPlaylist/{cod_usuario}/{cod_playlist}', 'obtenerComicsPlaylist');
    Route::get('/portadasC/{comicId}', 'getPortadaC')->name('getPortadaC');
    Route::get('/comicPlaylistXTitulo/{cod_usuario}/{cod_playlist}', 'obtenerComicsPlaylistTitulo');
});

Route::controller(PlaylistController::class)->group(function (){
    Route::get('/playlists/{idUsuario}', 'obtenerPlaylist');
    Route::get('/portadaPlaylist/{playlistId}', 'getPortadaPlaylist')->name('getPortadaPlaylist');
    Route::get('/playlist/{idUsuario}/{idPlaylist}', 'datosPlaylist');
    Route::match(['get', 'post'], '/updatePlaylist', 'updatePlaylist');
    Route::match(['get', 'post'], '/eliminarPlaylist', 'eliminarPlaylist');
});

Route::controller(ContenidoController::class)->group(function (){
    Route::get('/comicsSinContenido', 'comicsSinContenido');
    Route::match(['get', 'post'], '/registroContenidoComic', 'registrarContenido');
    //Route::get('/portadasCC/{comicId}', 'getPortadaCC')->name('getPortadaCC');
});
// Route::get('/images/{id}',[ListComicController::class, 'images']);

// Route::get('/images',[ListComicController::class, 'images']);

Route::get('/comics',[ListComicController::class, 'index']);

Route::get('/listascomics',[ListComicController::class, 'listasComic']);

Route::controller(BuscarController::class)->group(function (){
    Route::get('/buscar/{nombreComic}', 'comicFiltrar');
    Route::get('/artista/{nombreAutor}', 'filtrarArtista');
    Route::get('/anio/{anioDeseado}', 'filtrarAnio');
    Route::get('/sinopsis/{sinopsisIn}', 'filtrarSinopsis');
    Route::get('/prueba', 'prueba');
    Route::get('/portadas/{comicId}', 'getPortada')->name('getPortada');
    Route::get('/imagen/{imgId}', 'getImagen');
    Route::get('/comic/{id}', 'comic');
});

//Route::post('/RegistroComics',[RegistroController::class, 'register']);


// Route::get('/descargar', [ListComicController::class, 'images'])->name('comic.descargar');

//Route::get('/comics/{id}', [ListComicController::class, 'images']);
//Route::get('/json', [ListComicController::class, 'index']);

// Route::post('/register', 'ComicController@register');

//Route::post('/RegistroComics',[RegistroController::class, 'register']);

Route::match(['get', 'post'], '/registro', [RegistroController::class, 'register']);

Route::match(['get', 'post'], '/registroplay', [CrearPlaylistController::class, 'registro']);
Route::get('/listasPlaylist/{idUsuario}',[CrearPlaylistController::class, 'getPlaylist']);
Route::match(['get', 'post','delete'],'/deleteComicPlaylist',[ComicPlaylistController::class, 'destroy']);
// Route::match(['get', 'post'], '/ComicFavoritos', [ListfavoritosController::class, 'registroComicFavoritos']);
Route::match(['get', 'post'], '/ComicFavoritos', [ComicFavoritosController::class, 'registroComicFavoritos']);
//Route::get('/registro-usuario', 'RegistroUsuarioController@index')->name('registro-usuario.index');
//Route::post('/registro-usuario', 'RegistroUsuarioController@registrar')->name('registro-usuario.registrar');
Route::match(['get', 'post'], '/registro-usuario', [RegistroUsuarioController::class, 'registrar']);

Route::get('/verificar-credenciales', [UserController::class, 'verificarCredenciales']);
Route::get('/incrementarFallidos/{username}', [UserController::class, 'incrementarFallidos']);

Route::get('/verificar-correo/{email}', [AuthController::class,'verificarCorreo']);

Route::post('/reset-password', [ResetPasswordController::class,'resetPassword']);



