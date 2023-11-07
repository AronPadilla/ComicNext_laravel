<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        // $request->validate([
        //     'new_password' => 'required|min:8',
        // ]);

        // Recibe la nueva contraseña desde el frontend
        $newPassword = $request->input('new_password');

        //$user = User::find(auth()->id());
        $user = User::find($request->cod);

        // Verificar que la nueva contraseña no sea igual a una contraseña anterior
        if (Hash::check($newPassword, $user->password)) {
            return response()->json(['message' => 'La nueva contraseña no puede ser igual a una contraseña anterior.'], 400);
        }

        // Actualizar la contraseña del usuario
        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Contraseña restablecida con éxito.']);
    }
}
