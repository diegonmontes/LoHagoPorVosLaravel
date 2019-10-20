<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabilidadpersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilidadpersona', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idHabilidadPersona');
            $table->integer('idHabilidad')->unsigned()->nullable(false);
            $table->integer('idPersona')->unsigned()->nullable(false);
            $table->tinyInteger('eliminado')->default(0);
            $table->foreign('idHabilidad')->references('idHabilidad')->on('habilidad');
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
        Schema::dropIfExists('habilidadpersona');
    }
}
