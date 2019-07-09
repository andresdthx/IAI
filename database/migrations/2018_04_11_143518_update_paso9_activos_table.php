<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaso9ActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activos', function ($table) {
            $table->string('uso_comercial')->nullable();
            $table->string('cual_uso_comercial')->nullable();
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
            $table->dropColumn('uso_comercial');
            $table->dropColumn('cual_uso_comercial');
        });
    }
}
