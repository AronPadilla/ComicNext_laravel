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
        Schema::create('me_gusta', function (Blueprint $table) {
            $table->integer('cod_usuario')->index('le_gusta_comic_fk');
            $table->integer('cod_comic')->index('es_gustado_fk');

            $table->primary(['cod_usuario', 'cod_comic']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('me_gusta');
    }
};
