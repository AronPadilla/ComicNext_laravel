<?php

namespace App\Http\Controllers;

use App\Models\comic; // Agrega un punto y coma al final de esta línea

use Illuminate\Http\Request;

class ListComicController extends Controller
{
    public function index()
    {
    $comic = comic::all(); // Corrige el nombre de la variable a $comics

        return response()->json($comic);
    }
}
