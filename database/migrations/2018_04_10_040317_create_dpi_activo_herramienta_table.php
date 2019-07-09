<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDpiActivoHerramientaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpiherramientas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activo_id');
            $table->integer('dpi_id');
            $table->integer('herramienta_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dpiherramientas');
    }
}
