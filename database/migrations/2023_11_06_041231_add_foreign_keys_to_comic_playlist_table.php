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
        Schema::table('comic_playlist', function (Blueprint $table) {
            $table->foreign(['cod_comic'], 'fk_comic_pl_pertenece_comic')->references(['cod_comic'])->on('comic')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign(['cod_usuario', 'cod_playlist'], 'fk_comic_pl_tiene_com_playlist')->references(['cod_usuario', 'cod_playlist'])->on('playlist')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comic_playlist', function (Blueprint $table) {
            $table->dropForeign('fk_comic_pl_pertenece_comic');
            $table->dropForeign('fk_comic_pl_tiene_com_playlist');
        });
    }
};
