<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idTrabajo');
            $table->integer('idEstado')->unsigned()->nullable(false);
            $table->integer('idCategoriaTrabajo')->unsigned()->nullable(false);
            $table->integer('idPersona')->unsigned()->nullable(false);
            $table->integer('idLocalidad')->unsigned()->nullable(false);
            $table->string('titulo',255);
            $table->string('descripcion',511);
            $table->float('monto',8,2);
            $table->string('imagenTrabajo',511);
            $table->timestamps('tiempoExpiracion');
            $table->tinyInteger('eliminado')->default(0);
            $table->timestamps();
            $table->foreign('idEstado')->references('idEstado')->on('estado');
            $table->foreign('idCategoriaTrabajo')->references('idCategoriaTrabajo')->on('categoriaTrabajo');
            $table->foreign('idPersona')->references('idPersona')->on('persona');
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
        Schema::dropIfExists('trabajo');
    }
}
