<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    use HasFactory;
    protected $table = 'contenido'; 
    protected $fillable = ['cod_comic','nro_pagina', 'pagina'];
    public $timestamps = false;
 
    protected $primaryKey = ['cod_comic','nro_pagina']; 
    public $incrementing = false;
 
}
