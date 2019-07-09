<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDirectorDeGrupoInvestigacion extends Migration 
{
    public function up() {
        Schema::table('proyectos', function ($table) {
            $table->string('director_del_grupo')->nullable();
        });
    }

    public function down() {

        Schema::table('proyectos', function ($table) {
            $table->dropColumn('director_del_grupo');
        });
    }
}
