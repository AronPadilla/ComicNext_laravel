<?php

use App\Http\Controllers\RegistroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ListComicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comics',[ListComicController::class, 'index']);

Route::controller(ComicController::class)->group(function (){
    Route::get('/categoria/{nombreCategoria}', 'comicsXCategoria');
    Route::get('/prueba', 'prueba');
    Route::get('/portadas/{comicId}', 'getPortada')->name('getPortada');
    Route::get('/imagen/{imgId}', 'getImagen');
});

// Route::get('/images/{id}',[ListComicController::class, 'images']);

Route::get('/images/{id}',[ListComicController::class, 'images']);

Route::get('/comics',[ListComicController::class, 'index']);


//Route::post('/RegistroComics',[RegistroController::class, 'register']);
