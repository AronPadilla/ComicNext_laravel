<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $table = 'playlist'; 

    protected $fillable = ['cod_usuario','cod_playlist','nombre_playlist','imagen_playlist'];
    public $timestamps = false;
 
    protected $primaryKey = ['cod_usuario', 'cod_playlist']; // Columnas que actúan como clave primaria
}
