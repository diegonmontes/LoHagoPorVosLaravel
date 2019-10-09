<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajoasignadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajoasignado', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idTrabajoAsignado');
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
        Schema::dropIfExists('trabajoasignado');
    }
}
