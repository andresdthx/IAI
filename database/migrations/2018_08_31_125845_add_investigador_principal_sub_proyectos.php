<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvestigadorPrincipalSubProyectos extends Migration {

    public function up()
    {
        Schema::table('subproyectos', function ($table) {
            $table->text('investigador_principal')->nullable();
        });
    }

    public function down()
    {
        Schema::table('subproyectos', function ($table) {
            $table->dropColumn('investigador_principal');
        });
    }
}
