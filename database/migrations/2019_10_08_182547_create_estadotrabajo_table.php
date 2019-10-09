<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadotrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadotrabajo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idEstadoTrabajo');
            $table->integer('idTrabajo')->unsigned()->nullable(false);
            $table->integer('idEstado')->unsigned()->nullable(false);
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
            $table->foreign('idEstado')->references('idEstado')->on('estado');
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
        Schema::dropIfExists('estadotrabajo');
    }
}
