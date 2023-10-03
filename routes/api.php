<?php

use App\Http\Controllers\RegistroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\ListComicController;

=======
use App\Http\Controllers\ComicController;
>>>>>>> 3c7e88af5d97e086891e523a7fb3357e5b52363a
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

// Route::get('/comics', [ListComicController::class, 'images']);


Route::controller(ComicController::class)->group(function (){
    Route::get('/categoria/{nombreCategoria}', 'comicsXCategoria');
});
<<<<<<< HEAD

// Route::get('/descargar', [ListComicController::class, 'images'])->name('comic.descargar');

Route::get('/comics/{id}', [ListComicController::class, 'images']);

=======
//Route::post('/RegistroComics',[RegistroController::class, 'register']);
>>>>>>> 3c7e88af5d97e086891e523a7fb3357e5b52363a
