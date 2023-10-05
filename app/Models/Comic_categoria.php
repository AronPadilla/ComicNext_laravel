<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic_categoria extends Model
{
    use HasFactory;
    protected $table = 'comic_categoria'; // Cambio "Protected" a "protected"

    protected $fillable = ['cod_categoria', 'cod_comic'];
    public $timestamps = false;
 
    protected $primaryKey = ['cod_comic', 'cod_categoria']; // Columnas que actúan como clave primaria
    public $incrementing = false; // Indica que no se deben utilizar valores autoincrementales
}
