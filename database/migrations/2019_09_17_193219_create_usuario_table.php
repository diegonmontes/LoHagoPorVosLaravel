<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idUsuario');
            $table->string('nombreUsuario',80);
            $table->string('mailUsuario',80)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('auth_key',255)->nullable();
            $table->string('claveUsuario',255);
            $table->integer('idRol')->unsigned();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('idRol')->references('idRol')->on('rol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
