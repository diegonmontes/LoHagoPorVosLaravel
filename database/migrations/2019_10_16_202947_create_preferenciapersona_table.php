<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferenciapersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferenciapersona', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idPreferenciaPersona');
            $table->integer('idCategoriaTrabajo')->unsigned()->nullable(false);
            $table->integer('idPersona')->unsigned()->nullable(false);
            $table->tinyInteger('eliminado')->default(0);
            $table->foreign('idCategoriaTrabajo')->references('idCategoriaTrabajo')->on('categoriaTrabajo');
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
        Schema::dropIfExists('preferenciapersona');
    }
}
