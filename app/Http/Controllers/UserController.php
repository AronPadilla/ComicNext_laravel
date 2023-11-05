<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UserController extends Controller
{
    public function verificarCredenciales(Request $request)
    {
        $username = $request->input('nombre_u');
        $password = $request->input('password');

        $user = Usuario::where('nombre_u', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            $correo = $user->correo;
            $details = [
                'title' => 'Comic Nexus',
                'content' => 'Bienvenido A Comic Nexux, tu resgistro ha sido exitoso.',
            ];
           
            \Mail::to($correo)->send(new \App\Mail\TestMail($details));
            return response()->json(['cod_usuario' => $user->cod_usuario]);
        } else {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    }

    public function incrementarFallidos(Request $request, $username){
        //$username = $request->input('nombre_u');

        Usuario::where('nombre_u', $username)->increment('nro_fallidos');
        $nuevoNroFallidos = Usuario::where('nombre_u', $username)->value('nro_fallidos');
        return $nuevoNroFallidos;
    }
}
