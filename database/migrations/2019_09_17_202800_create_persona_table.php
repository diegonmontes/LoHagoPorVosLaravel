<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->bigIncrements('idPersona');
            $table->string('nombrePersona');
            $table->string('apellidoPersona');
            $table->string('dniPersona')->unique();
            $table->string('telefonoPersona');
            $table->integer('idLocalidad')->unsigned();;
            $table->integer('idUsuario')->unsigned();;
            $table->tinyInteger('eliminado');
            $table->timestamps();
            $table->foreign('idLocalidad')->references('idLocalidad')->on('localidad');
            $table->foreign('idUsuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
