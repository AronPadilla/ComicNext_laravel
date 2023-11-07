<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario; // Asegúrate de usar el modelo correcto

class AuthController extends Controller
{
    public function verificarCorreo(Request $request,$email)
    {
        // $request->validate([
        //     'email' => 'required|email',
        // ]);

        $usuario = Usuario::where('correo', $email)->first();

        if ($usuario) {
            // El correo existe en la base de datos
            $correo = $usuario -> correo;
            $details = [
                'nombre' => $usuario->nombre_u,
                'link' => 'https://comicnexus.onrender.com/restablecer-contrase%C3%B1a',
            ];
            
            \Mail::to($correo)->send(new \App\Mail\RecuperarMail($details));
            return response()->json(['message' => 'Correo verificado','nuevo' => $usuario->cod_usuario]);
        } else {
            return response()->json(['message' => 'Correo no encontrado'], 404);
        }
    }
}
