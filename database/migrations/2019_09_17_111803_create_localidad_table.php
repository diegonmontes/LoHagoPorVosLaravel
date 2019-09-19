<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidad', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idLocalidad');
            $table->string('nombreLocalidad');
            $table->integer('idProvincia')->unsigned();
            $table->smallInteger('codigoPostal');
            $table->timestamps();
            $table->foreign('idProvincia')->references('idProvincia')->on('provincia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidad');
    }
}
