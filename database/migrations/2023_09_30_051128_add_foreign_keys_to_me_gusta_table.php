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
        Schema::table('me_gusta', function (Blueprint $table) {
            $table->foreign(['cod_comic'], 'fk_me_gusta_es_gustad_comic')->references(['cod_comic'])->on('comic')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign(['cod_usuario'], 'fk_me_gusta_le_gusta__usuario')->references(['cod_usuario'])->on('usuario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('me_gusta', function (Blueprint $table) {
            $table->dropForeign('fk_me_gusta_es_gustad_comic');
            $table->dropForeign('fk_me_gusta_le_gusta__usuario');
        });
    }
};
