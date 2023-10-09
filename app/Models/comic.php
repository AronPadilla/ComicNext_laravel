<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comic extends Model
{
    use HasFactory;
    protected $table = 'comic';

    protected $fillable = ['titulo', 'autor', 'sinopsis', 'anio_publicacion', 'portada'];
    public $timestamps = false;

    protected $primaryKey = 'cod_comic';
}