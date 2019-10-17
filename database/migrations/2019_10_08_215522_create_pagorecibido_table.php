<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagorecibidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagorecibido', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idPagoRecibido');
            $table->integer('idTrabajo')->unsigned()->nullable(false);
            $table->string('idPago',255)->nullable(false);
            $table->float('monto',8,2)->nullable(false);
            $table->string('metodo',255)->nullable(false);
            $table->string('tarjeta',255)->nullable(false);
            $table->timestamp('fechapago')->nullable(true);
            $table->timestamp('fechaaprobado')->nullable(true);
            $table->tinyInteger('eliminado')->default(0);
            $table->foreign('idTrabajo')->references('idTrabajo')->on('trabajo');
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
        Schema::dropIfExists('pagorecibido');
    }
}
