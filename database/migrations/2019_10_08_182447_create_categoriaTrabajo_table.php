<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoriaTrabajo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idCategoriaTrabajo');
            $table->string('nombreCategoriaTrabajo',80);
            $table->string('descripcionCategoriaTrabajo',255);
            $table->string('imagenCategoriaTrabajo',511)->nullable(true);;
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
        Schema::dropIfExists('categoriaTrabajo');
    }
}
