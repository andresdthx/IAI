<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivoIdActivos extends Migration {

    public function up() {
        Schema::table('activos', function ($table) {
            $table->integer('activo_id')->nullable();
            $table->string('commit')->nullable();
            $table->string('commit_field')->nullable();
        });
    }

    public function down() {

        Schema::table('activos', function ($table) {
            $table->dropColumn('activo_id');
            $table->dropColumn('commit');
            $table->dropColumn('commit_field');
        });
    }
}
