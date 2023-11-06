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
        Schema::create('comic_playlist', function (Blueprint $table) {
            $table->integer('cod_comic')->index('pertenece_playllist_fk');
            $table->integer('cod_usuario');
            $table->integer('cod_playlist');
            $table->timestamp('creacion_time')->nullable()->useCurrent();

            $table->primary(['cod_usuario', 'cod_comic', 'cod_playlist']);
            $table->unique(['cod_usuario', 'cod_comic', 'cod_playlist'], 'comic_playlist_pk');
            $table->index(['cod_usuario', 'cod_playlist'], 'tiene_comics_fk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic_playlist');
    }
};
