<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_fac', 10)->unique();
            $table->dateTime('fecha_hora');
            $table->decimal('iva', 4, 2);
            $table->decimal('total', 11, 2);
            $table->string('estado', 20);
            $table->integer('id_proveedor')->unsigned();
            $table->foreign('id_proveedor')->references('id')->on('proveedores');
            $table->integer('id_usuario')->unsigned();
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('entradas');
    }
}
