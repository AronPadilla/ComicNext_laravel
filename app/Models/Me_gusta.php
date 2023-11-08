<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Me_gusta extends Model
{
    use HasFactory;
    protected $table = 'me_gusta'; 
    protected $fillable = ['cod_usuario','cod_comic','fecha_creacion'];
    public $timestamps = false;
 
    protected $primaryKey = ['cod_usuario','cod_comic']; 
    public $incrementing = false; 
}
