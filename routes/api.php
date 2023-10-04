<?php

use App\Http\Controllers\RegistroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\ComicController;
use App\Http\Controllers\ListComicController;

=======

use App\Http\Controllers\ListComicController;

use App\Http\Controllers\ComicController;

>>>>>>> 7382d7a16c25b28ad279db016af22221e1f8f3ff
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

// Route::get('/images/{id}',[ListComicController::class, 'images']);
=======
// Route::get('/descargar', [ListComicController::class, 'images'])->name('comic.descargar');
>>>>>>> 7382d7a16c25b28ad279db016af22221e1f8f3ff

Route::get('/images/{id}',[ListComicController::class, 'images']);

Route::get('/comics',[ListComicController::class, 'index']);

<<<<<<< HEAD
=======

//Route::post('/RegistroComics',[RegistroController::class, 'register']);
>>>>>>> 7382d7a16c25b28ad279db016af22221e1f8f3ff
