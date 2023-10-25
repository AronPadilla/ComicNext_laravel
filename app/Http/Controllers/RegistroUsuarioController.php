<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroUsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        // Validar los datos del formulario (debes personalizar estas validaciones)
       // $request->validate([
         //   'name' => 'required',
           // 'username' => 'required|unique:usuario',
            //'email' => 'required|email|unique:usuario',
            //'password' => 'required|min:6',
       // ]

        // Crear un nuevo usuario en la base de datos 
        $usuario = new Usuario();
        $usuario->nombre_completo = $request->name;
        $usuario->nombre_u = $request->username;
        $usuario->correo = $request->email;
        $usuario->password = bcrypt($request->password); // Hash de la contraseña
        $usuario->cod_rol = 2; 

        $usuario->save();

        // Respuesta de éxito
        return response()->json(['message' => 'Usuario registrado con éxito']);
    }
    public function CorreoExistente($correo)
{
    $usuario = DB::table('user')->where('correo', $correo)->first();
    if (!$usuario){
        return response ()->json(['exists'=>false]);

    }else{
        return response()->json(['exist'=>true]);
    }
}}