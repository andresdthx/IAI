<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponsableMoficiacionActivos extends Migration
{
    public function up() {
        Schema::table('activos', function ($table) {
            $table->string('responsable_modificacion_email')->nullable();
            $table->string('responsable_modificacion_nombre')->nullable();
        });
    }

    public function down() {

        Schema::table('activos', function ($table) {
            $table->dropColumn('responsable_modificacion_email');
            $table->dropColumn('responsable_modificacion_nombre');
        });
    }
}
