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
        Schema::create('playlist', function (Blueprint $table) {
            $table->integer('cod_usuario')->index('tiene_playlist_fk');
            $table->increments('cod_playlist');
            $table->string('nombre_playlist', 60);
            $table->binary('imagen_playlist');

            $table->primary(['cod_usuario', 'cod_playlist']);
            $table->unique(['cod_usuario', 'cod_playlist'], 'playlist_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist');
    }
};
