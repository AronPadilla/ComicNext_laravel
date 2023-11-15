<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\UsuarioBloqueado;
use Carbon\Carbon;

class UserController extends Controller
{
    public function verificarCredenciales(Request $request)
    {
        $username = $request->input('nombre_u');
        $password = $request->input('password');
        $user = Usuario::where('nombre_u', $username)->first();
        if($user){
            $bloqueado =  $this->verificarCuentaBloqueada($user->cod_usuario);
            if(!$bloqueado){
                //$user = Usuario::where('nombre_u', $username)->first();
                if (password_verify($password, $user->password)) {
                    $user->nro_fallidos = 0;
                    $user->update();
                    return response()->json(['cod_usuario' => $user->cod_usuario]);
                
                } else {
                    $this->incrementarFallidos($username);
                    if($user->nro_fallidos >= 5){
                        $this->bloquearCuenta($user->cod_usuario);
                    }
                    return response()->json(['error' => 'Credenciales incorrectas'], 401);
                }
            }else{
                return response()->json(['error' => 'Cuenta bloqueada'], 401);
            }
        }else{
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    }

    public function incrementarFallidos($username){
        Usuario::where('nombre_u', $username)->increment('nro_fallidos');
        $nuevoNroFallidos = Usuario::where('nombre_u', $username)->value('nro_fallidos');
        return $nuevoNroFallidos;
    }

    public function verificarCuentaBloqueada($idUser){
        $tiempoActual = Carbon::now();  
        $user = UsuarioBloqueado::where('cod_usuario', $idUser)->first();
        if($user){
            if($tiempoActual<$user->fin_bloqueo){
                return true;
            }else{
                $this->desbloquearCuenta($idUser);
                return false;
            }
        }else{
            return false;
        }
    }

    public function bloquearCuenta( $idUser){
        try{
            $creacionTime = Carbon::now();

            $usuarioBloqueado = new UsuarioBloqueado();
            $usuarioBloqueado->cod_usuario = $idUser;
            $usuarioBloqueado->inicio_bloqueo = $creacionTime;
            $usuarioBloqueado->fin_bloqueo =  $creacionTime->copy()->addHour();
            $usuarioBloqueado->save();
            //return response()->json(['mensaje' => 'Usuario bloqueado']);
        } catch (\Exception $e) {
            
            //return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function desbloquearCuenta($idUser){
        $usuarioBloqueado = UsuarioBloqueado::where('cod_usuario', $idUser)->first();

        if ($usuarioBloqueado) {
            // Si se encuentra una fila con el ID de usuario, eliminarla
            $user = Usuario::where('cod_usuario', $idUser)->first();
            $user -> nro_fallidos = 0;
            $user->update();

            $usuarioBloqueado->delete();
            return response()->json(['mensaje' => 'Usuario desbloqueado']);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 401);
        }
    }

    public function cambiarNomUser(Request $request){
        $user = Usuario::where('cod_usuario',  $request->idUser)->first();
        if($user){
            $user -> nombre_u = $request->nomUser;
            $user->update();

            return response()->json(['usuario' => $user]);
        }else{
            return response()->json(['error' => 'Usuario no encontrado'], 401);
        }
    }
}
