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
            return response()->json(['cod_usuario' => $user->cod_usuario]);
        } else {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    }
}
