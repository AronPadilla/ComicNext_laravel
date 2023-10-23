<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuario'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'cod_usuario'; // Clave primaria de la tabla (si es diferente a "id")
    public $timestamps = false;
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
