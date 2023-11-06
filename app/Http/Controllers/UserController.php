<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\UsuarioBloqueado;

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

    public function incrementarFallidos(Request $request, $username){
        Usuario::where('nombre_u', $username)->increment('nro_fallidos');
        $nuevoNroFallidos = Usuario::where('nombre_u', $username)->value('nro_fallidos');
        return $nuevoNroFallidos;
    }

    public function verificarCuentaBloqueada($idUser){
        $user = UsuarioBloqueado::where('cod_usuario', $idUser)->first();
        if($user){
            return true;
        }else{
            return false;
        }
    }

    public function bloquearCuenta(Request $request, $idUser){
        try{
            $creacionTime = now();

            $usuarioBloqueado = new UsuarioBloqueado();
            $usuarioBloqueado->cod_usuario = $idUser;
            $usuarioBloqueado->inicio_bloqueo = $creacionTime;
            $usuarioBloqueado->fin_bloque = $creacionTime->addHour();

            return response()->json(['mensaje' => 'Usuario bloqueado']);
        } catch (\Exception $e) {
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function desbloquearCuenta(Request $request, $idUser){
        $usuarioBloqueado = UsuarioBloqueado::where('cod_usuario', $idUser)->first();

        if ($usuarioBloqueado) {
            // Si se encuentra una fila con el ID de usuario, eliminarla
            $usuarioBloqueado->delete();
            return response()->json(['mensaje' => 'Usuario desbloqueado']);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 401);
        }
    }
}
