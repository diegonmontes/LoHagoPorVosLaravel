<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajechatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajechat', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idMensajeChat');
            $table->integer('idConversacionChat')->unsigned()->nullable(false);
            $table->integer('idPersona')->unsigned()->nullable(false);
            $table->string('mensaje',511);
            $table->tinyInteger('eliminado')->default(0);
            $table->tinyInteger('visto')->default(0);
            $table->timestamp('fechaVisto')->nullable(false);
            $table->timestamps();
            $table->foreign('idConversacionChat')->references('idConversacionChat')->on('conversacionchat');
            $table->foreign('idPersona')->references('idPersona')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensajechat');
    }
}

