<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversacionchatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversacionchat', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idConversacionChat');
            $table->integer('idTrabajo')->unsigned()->nullable(false);
            $table->integer('idPersona1')->unsigned()->nullable(false);
            $table->integer('idPersona2')->unsigned()->nullable(false);
            $table->tinyInteger('eliminado')->default(0);
            $table->timestamps();
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
            $table->foreign('idPersona1')->references('idPersona')->on('persona');
            $table->foreign('idPersona2')->references('idPersona')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversacionchat');
    }
}
