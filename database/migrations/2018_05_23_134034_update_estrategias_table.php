<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstrategiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('estrategias', function ($table) {
            $table->text('nombre_paso')->nullable();
            $table->text('campo')->nullable();
            $table->text('estado')->nullable();
            $table->dropColumn('estrategia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('estrategias', function ($table) {
            $table->dropColumn('nombre_paso');
            $table->dropColumn('campo');
            $table->dropColumn('estado');
            $table->text('estrategia');
        });
    }
}
