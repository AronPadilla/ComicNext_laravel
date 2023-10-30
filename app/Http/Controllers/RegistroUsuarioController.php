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
        $nombreUsuario = $request->input('username');
    
        // Verifica si el correo ya está registrado
        $correoExistente = DB::table('usuario')->where('correo', $correo)->exists();
        
        // Verifica si el nombre de usuario ya está registrado
        $nombreUsuarioExistente = DB::table('usuario')->where('nombre_u', $nombreUsuario)->exists();
        
        if ($correoExistente && $nombreUsuarioExistente) {
            return response()->json(['message' => 'Correo y nombre de usuario ya están registrados en esta página'], 409);
        } elseif ($correoExistente) {
            return response()->json(['message' => 'Correo ya está registrado en esta página'],409);
        } elseif ($nombreUsuarioExistente) {
            return response()->json(['message' => 'Nombre de usuario ya está registrado en esta página'],409);
        }
    
        // Si ni el correo ni el nombre de usuario están registrados, procede con el registro del usuario
        $usuario = new Usuario();
        $usuario->nombre_completo = $request->input('name');
        $usuario->nombre_u = $nombreUsuario;
        $usuario->correo = $correo;
        $usuario->password = bcrypt($request->input('password'));
        $usuario->cod_rol = 2;
        $usuario->save();
        
        return response()->json(['message' => 'El usuario ha sido registrado con éxito']);
    }
    
    
}