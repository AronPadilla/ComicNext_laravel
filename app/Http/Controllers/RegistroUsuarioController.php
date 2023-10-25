<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroUsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        $correo = $request->input('email');

        // Verifica si el correo ya está registrado
        $usuarioExistente = DB::table('usuario')->where('correo', $correo)->exists();

        if ($usuarioExistente) {
            return response()->json(['message' => 'Correo ya registrado']);
        }

        // Si el correo no está registrado, procede con el registro del usuario
        $usuario = new Usuario();
        $usuario->nombre_completo = $request->input('name');
        $usuario->nombre_u = $request->input('username');
        $usuario->correo = $correo;
        $usuario->password = bcrypt($request->input('password'));
        $usuario->cod_rol = 2;

        $usuario->save();

        return response()->json(['message' => 'El usuario ha sido registrado con éxito']);
    }
}
