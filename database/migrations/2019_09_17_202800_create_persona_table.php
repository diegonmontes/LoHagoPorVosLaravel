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
            $table->increments('idPersona');
            $table->string('nombrePersona');
            $table->string('apellidoPersona');
            $table->string('dniPersona')->unique();
            $table->string('telefonoPersona');
            $table->integer('idUsuario')->unsigned();
            $table->integer('idLocalidad')->unsigned();
            $table->tinyInteger('eliminado')->nullable();
            $table->timestamps();
            $table->foreign('idUsuario')->references('idUsuario')->on('usuario');
            $table->foreign('idLocalidad')->references('idLocalidad')->on('localidad');
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
