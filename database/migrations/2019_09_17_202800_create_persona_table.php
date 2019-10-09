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
            $table->string('nombrePersona',80)->nullable(false);
            $table->string('apellidoPersona',80)->nullable(false);
            $table->string('dniPersona',10)->unique()->nullable(false);
            $table->string('telefonoPersona',32);
            $table->string('imagenPersona',511)->default('fotoperfil.png');
            $table->integer('idUsuario')->unsigned()->nullable(false);
            $table->integer('idLocalidad')->unsigned()->nullable(false);
            $table->tinyInteger('eliminado')->default(0);
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
