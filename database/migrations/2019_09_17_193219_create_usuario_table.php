<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idUsuario');
            $table->string('nombreUsuairo',80);
            $table->string('emailUsuario',80)->unique();
            $table->string('auth_key',255);
            $table->string('claveUsuario',255);
            $table->integer('idRol')->unsigned();
            $table->timestamps();
            $table->foreign('idRol')->references('idRol')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
