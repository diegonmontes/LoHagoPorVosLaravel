<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabilidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilidad', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idHabilidad');
            $table->string('nombreHabilidad',80);
            $table->string('descripcionHabilidad',255);
            $table->string('imagenHabilidad',511)->nullable(true);
            $table->tinyInteger('eliminado')->default(0);
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
        Schema::dropIfExists('habilidad');
    }
}
