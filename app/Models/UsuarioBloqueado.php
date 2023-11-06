<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioBloqueado extends Model
{
    use HasFactory;
    protected $table = 'usuario_bloqueado'; 

    protected $fillable = ['cod_usuario','inicio_bloqueo','fin_bloqueo'];
    public $timestamps = false;

    protected $primaryKey = 'cod_bloqueado';
    public $incrementing = true;
}
