<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaso8ActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activos', function ($table) {
            $table->string('busqueda')->nullable();
            $table->string('presupuesto_priorizacion')->nullable();
            $table->double('cantidad_presupuesto', 8, 2)->nullable();

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
            $table->dropColumn('busqueda');
            $table->dropColumn('presupuesto_priorizacion');
            $table->dropColumn('cantidad_presupuesto');

        });
    }
}
