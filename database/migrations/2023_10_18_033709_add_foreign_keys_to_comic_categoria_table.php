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
        Schema::table('comic_categoria', function (Blueprint $table) {
            $table->foreign(['cod_comic'], 'fk_comic_ca_tiene_cat_comic')->references(['cod_comic'])->on('comic')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign(['cod_categoria'], 'fk_comic_ca_tiene_com_categori')->references(['cod_categoria'])->on('categoria')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comic_categoria', function (Blueprint $table) {
            $table->dropForeign('fk_comic_ca_tiene_cat_comic');
            $table->dropForeign('fk_comic_ca_tiene_com_categori');
        });
    }
};
