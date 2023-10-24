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
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('nombre_u', 50)->unique();
            $table->string('password', 200);
            $table->increments('cod_usuario');
            $table->integer('cod_rol')->index('tiene_rol_fk');
            $table->string('nombre_completo', 150);
            $table->string('correo', 200)->unique();

            $table->unique(['cod_usuario'], 'usuario_pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
