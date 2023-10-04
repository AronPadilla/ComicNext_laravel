<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comic', function (Blueprint $table) {
            $table->increments('cod_comic');
            $table->string('titulo', 60);
            $table->string('autor', 100)->nullable();
            $table->string('sinopsis', 500)->nullable();
            $table->integer('anio_publicacion')->nullable();
            $table->binary('portada')->nullable();
           

            $table->unique(['cod_comic'], 'comic_pk');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic');
    }
};
