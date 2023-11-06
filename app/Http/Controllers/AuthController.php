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
                'title' => 'Comic Nexus',
                'content' => 'Bienvenido A Comic Nexus, tu resgistro ha sido exitoso.',
            ];
            
            \Mail::to($correo)->send(new \App\Mail\TestMail($details));
            return response()->json(['message' => 'Correo verificado']);
        } else {
            return response()->json(['message' => 'Correo no encontrado'], 404);
        }
    }
}
