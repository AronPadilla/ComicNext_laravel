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
        Schema::table('contenido', function (Blueprint $table) {
            $table->foreign(['cod_comic'], 'fk_contenid_tiene_det_comic')->references(['cod_comic'])->on('comic')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contenido', function (Blueprint $table) {
            $table->dropForeign('fk_contenid_tiene_det_comic');
        });
    }
};
