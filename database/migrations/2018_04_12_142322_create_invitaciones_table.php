<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->string('rol');
            $table->string('correo');
            $table->date('fecha_expiracion');
            $table->boolean('valido');
            $table->string('codigo');
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
        Schema::dropIfExists('invitaciones');
    }
}
