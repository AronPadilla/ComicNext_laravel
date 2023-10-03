<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comic extends Model
{
    use HasFactory;
    protected $table = 'comic';
<<<<<<< HEAD
=======
    protected $fillable = ['titulo', 'autor', 'sinopsis', 'anio_publicacion', 'portada'];
    public $timestamps = false;
>>>>>>> 3c7e88af5d97e086891e523a7fb3357e5b52363a
    protected $primaryKey = 'cod_comic';
}
