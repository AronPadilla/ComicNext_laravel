<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

Route::get('/', function () {
    return view('Registro');
});

//Route::post('/',[RegistroController::class, 'register']);
//Route::get('/RegistroComics',[RegistroController::class, 'register']);
Route::post('/', [RegistroController::class, 'register'])->name('computer');

Route::get('send-mail/{email}', function ($email) {
    $correo = Usuario::where('correo', $email)->first();
    if ($correo) {
        $details = [
            'title' => 'Comic Nexus',
            'content' => 'Bienvenido A Comic Nexux, tu resgistro ha sido exitoso.',
        ];
       
        \Mail::to($email)->send(new \App\Mail\TestMail($details));
       
        return 'Email sent at ' . now();
    } else {
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }
});
