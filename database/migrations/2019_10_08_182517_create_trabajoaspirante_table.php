<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajoaspiranteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajoaspirante', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idTrabajoAspirantes');
            $table->integer('idTrabajo')->unsigned()->nullable(false);
            $table->integer('idPersona')->unsigned()->nullable(false);
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
            $table->foreign('idPersona')->references('idPersona')->on('persona');
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
        Schema::dropIfExists('trabajoaspirante');
    }
}
