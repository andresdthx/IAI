<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActivosDescripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('activos', function ($table) {
            $table->text('descripcion')->nullable();
            $table->string('clasificacion')->nullable();
            $table->string('estado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('activos', function($table) {
            $table->dropColumn('descripcion');
            $table->dropColumn('clasificacion');
            $table->dropColumn('estado');
        });
    }
}
