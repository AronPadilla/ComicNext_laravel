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
        Schema::create('comic_categoria', function (Blueprint $table) {
            $table->integer('cod_categoria')->index('tiene_comic_fk');
            $table->integer('cod_comic')->index('tiene_categoria_fk');

            $table->primary(['cod_categoria', 'cod_comic']);
            $table->unique(['cod_categoria', 'cod_comic'], 'comic_categoria_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comic_categoria');
    }
};
