<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMultaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multa', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idMulta');
            $table->integer('idTrabajo')->unsigned()->nullable(false);
            $table->integer('idPersona')->unsigned()->nullable(false);
            $table->string('motivo',511);
            $table->string('valor',16);
            $table->tinyInteger('eliminado')->default(0);
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
        {
            Schema::dropIfExists('multa');
        }
    }
}
