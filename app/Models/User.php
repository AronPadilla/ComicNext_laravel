<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'cod_usuario'; // Clave primaria de la tabla (si es diferente a "id")

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_u', 'password', 'cod_usuario', 'cod_rol', 'nombre_completo', 'correo'
    ];

    // Resto de las propiedades y métodos del modelo...
}
