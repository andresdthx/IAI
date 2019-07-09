<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activos', function ($table) {
            $table->string('deposito_da')->nullable();
            $table->string('numero_registro_da')->nullable();
            $table->string('registro_da')->nullable();
            $table->string('medidas_proteccion')->nullable();
            $table->text('cuales_medidas')->nullable();
            $table->string('propiedad_industrial')->nullable();
            $table->string('contratos')->nullable();
            $table->text('cuales_contratos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activos', function($table) {
            $table->dropColumn('deposito_da');
            $table->dropColumn('numero_registro_da');
            $table->dropColumn('registro_da');
            $table->dropColumn('medidas_proteccion');
            $table->dropColumn('cuales_medidas');
            $table->dropColumn('propiedad_industrial');
            $table->dropColumn('contratos')->nullable();
            $table->dropColumn('cuales_contratos')->nullable();
        });
    }
}
