<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic_playlist extends Model
{
    use HasFactory;
    protected $table = 'comic_playlist'; 

    protected $fillable = ['cod_comic',  'cod_usuario', 'cod_playlist'];
    public $timestamps = false;
 
    protected $primaryKey = ['cod_comic',  'cod_usuario', 'cod_playlist']; 
    public $incrementing = false;
}
