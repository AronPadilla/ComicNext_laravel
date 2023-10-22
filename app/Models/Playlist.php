<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
     use HasFactory;

    protected $table = 'playlist'; 
    protected $primaryKey = 'cod_playlist'; // Columna que actúa como clave primaria
    public $timestamps = false;
    public $incrementing = true; // Laravel asume que la clave primaria es autoincremental por defecto, por lo que esto debería estar en true

    // Indica las columnas que son asignables en masa
    protected $fillable = ['cod_usuario', 'nombre_playlist', 'imagen_playlist'];
 
    

}
