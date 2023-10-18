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
        Schema::create('contenido', function (Blueprint $table) {
            $table->integer('cod_comic')->index('tiene_detalle_fk');
            $table->integer('nro_pagina');
            $table->binary('pagina');

            $table->primary(['cod_comic', 'nro_pagina']);
            $table->unique(['cod_comic', 'nro_pagina'], 'contenido_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenido');
    }
};
