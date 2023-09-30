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
            $table->integer('cod_comic')->index('pertenece_playlist_fk');
            $table->integer('cod_usuario')->index('tiene_playlist_fk');
            $table->string('nombre_playlist', 60);

            $table->primary(['cod_comic', 'cod_usuario']);
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
