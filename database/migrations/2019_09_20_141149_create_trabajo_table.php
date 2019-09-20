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
            $table->integer('idPersona')->unsigned();
            $table->integer('idTipoTrabajo')->unsigned();
            $table->integer('idCategoriaTrabajo')->unsigned();
            $table->string('titulo',255);
            $table->string('descripcion',511);
            $table->float('monto',8,2);
            $table->tinyInteger('eliminado');
            $table->timestamps();
            $table->foreign('idPersona')->references('idPersona')->on('persona');
            $table->foreign('idTipoTrabajo')->references('idTipoTrabajo')->on('tipoTrabajo');
            $table->foreign('idCategoriaTrabajo')->references('idCategoriaTrabajo')->on('categoriaTrabajo');
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
