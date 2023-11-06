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
        Schema::create('usuario_bloqueado', function (Blueprint $table) {
            $table->integer('cod_usuario')->index('puede_estar_fk');
            $table->increments('cod_bloqueado');
            $table->timestamp('inicio_bloqueo')->nullable()->useCurrent();
            $table->timestamp('fin_bloqueo');

            $table->primary(['cod_usuario', 'cod_bloqueado']);
            $table->unique(['cod_usuario', 'cod_bloqueado'], 'usuario_bloqueado_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_bloqueado');
    }
};
