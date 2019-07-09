<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActivosSubproyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('activos', function ($table) {
            $table->integer('subproyecto_id')->nullable();
            $table->dropColumn('proyecto_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::table('activos', function ($table) {
            $table->dropColumn('subproyecto_id');
            $table->integer('proyecto_id')->nullable();
        });
    }
}
