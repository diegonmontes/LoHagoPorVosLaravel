<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->increments('idComentario');
            $table->text('contenido');
            $table->integer('idComentarioPadre')->unsigned()->nullable();
            $table->integer('idTrabajo')->unsigned();
            $table->integer('idPersona')->unsigned();
            $table->timestamps();
 
            $table->foreign('idComentarioPadre')->references('idComentario')->on('comentario');
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
            $table->foreign('idPersona')->references('idPersona')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario');
    }
}
