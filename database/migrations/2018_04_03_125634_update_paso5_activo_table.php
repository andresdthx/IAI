<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaso5ActivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('activos', function ($table) {
            $table->string('publicado_divulgado')->nullable();
            $table->string('lugar_publicacion')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->string('contrato_confidencialidad')->nullable();
            $table->string('nombre_titular')->nullable();
            $table->string('contrato_cesion')->nullable();
            $table->string('ubicacion_ai')->nullable();
            $table->string('en_contabilidad')->nullable();
            $table->float('valor_de_ai', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::table('activos', function($table) {
            $table->dropColumn('publicado_o_divulgado');
            $table->dropColumn('lugar_de_publicacion');
            $table->dropColumn('fecha_publicacion');
            $table->dropColumn('contrato_confidencialidad');
            $table->dropColumn('nombre_de_titular');
            $table->dropColumn('contrato_de_cesion');
            $table->dropColumn('ubicacion');
            $table->dropColumn('incorporado_contabilidad');
            $table->dropColumn('valor_dpi');
        });
    }
}
