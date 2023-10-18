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
        Schema::table('playlist', function (Blueprint $table) {
            $table->foreign(['cod_comic'], 'fk_playlist_pertenece_comic')->references(['cod_comic'])->on('comic')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign(['cod_usuario'], 'fk_playlist_tiene_pla_usuario')->references(['cod_usuario'])->on('usuario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playlist', function (Blueprint $table) {
            $table->dropForeign('fk_playlist_pertenece_comic');
            $table->dropForeign('fk_playlist_tiene_pla_usuario');
        });
    }
};
