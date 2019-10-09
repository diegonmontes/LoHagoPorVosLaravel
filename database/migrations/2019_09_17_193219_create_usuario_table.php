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
            $table->string('nombreUsuario',80)->nullable(false);
            $table->string('mailUsuario',80)->nullable(false)->unique();
            $table->string('auth_key',255)->nullable(true)->default(null);
            $table->string('claveUsuario',255)->nullable(false);
            $table->timestamp('email_verified_at')->nullable(true)->default(null);
            $table->tinyInteger('eliminado')->default(0);
            $table->integer('idRol')->unsigned()->nullable(false);
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
