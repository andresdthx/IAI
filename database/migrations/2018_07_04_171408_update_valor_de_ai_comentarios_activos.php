<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateValorDeAiComentariosActivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('activos', function ($table) {
            $table->text('valor_de_ai_comentarios')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activos', function ($table) {
            $table->dropColumn('valor_de_ai_comentarios');
        });
    }
}
