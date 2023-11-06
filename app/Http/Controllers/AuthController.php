<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Usuario; // Asegúrate de usar el modelo correcto

class AuthController extends Controller
{
    public function verificarCorreo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $usuario = Usuario::where('correo', $request->email)->first();

        if ($usuario) {
            // El correo existe en la base de datos
            return response()->json(['message' => 'Correo verificado']);
        } else {
            return response()->json(['message' => 'Correo no encontrado'], 404);
        }
    }
}
