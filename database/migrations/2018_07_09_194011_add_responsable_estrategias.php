<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResponsableEstrategias extends Migration
{
    public function up() {
        Schema::table('estrategias', function ($table) {
            $table->string('responsable')->nullable();

        });
    }

    public function down() {

        Schema::table('estrategias', function ($table) {
            $table->dropColumn('responsable');
        });
    }
}

