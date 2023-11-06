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
        Schema::table('usuario_bloqueado', function (Blueprint $table) {
            $table->foreign(['cod_usuario'], 'fk_usuario__puede_est_usuario')->references(['cod_usuario'])->on('usuario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_bloqueado', function (Blueprint $table) {
            $table->dropForeign('fk_usuario__puede_est_usuario');
        });
    }
};
