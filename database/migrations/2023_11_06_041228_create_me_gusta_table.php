<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeGustaTable extends Migration
{
    public function up()
    {
        Schema::create('me_gusta', function (Blueprint $table) {
            $table->unsignedBigInteger('cod_usuario');
            $table->unsignedBigInteger('cod_comic');
            $table->dateTime('fecha_creacion');
            // ... otras columnas si las necesitas ...

            $table->primary(['cod_usuario', 'cod_comic']);
            $table->foreign('cod_usuario')->references('id')->on('usuarios'); // Ajusta el nombre de la tabla 'usuarios' según tu estructura
            $table->foreign('cod_comic')->references('id')->on('comics'); // Ajusta el nombre de la tabla 'comics' según tu estructura
        });
    }

    public function down()
    {
        Schema::dropIfExists('me_gusta');
    }
}
