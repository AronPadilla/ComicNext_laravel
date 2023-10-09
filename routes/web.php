<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;


Route::get('/', function () {
    return view('Registro');
});
//Route::post('/',[RegistroController::class, 'register']);
//Route::get('/RegistroComics',[RegistroController::class, 'register']);
Route::post('/', [RegistroController::class, 'register'])->name('computer');