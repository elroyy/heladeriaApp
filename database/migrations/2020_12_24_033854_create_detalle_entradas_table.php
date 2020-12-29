<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('cantidad',11,2);
            $table->decimal('precio',11,2);
            $table->integer('id_producto')->unsigned();
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->integer('id_entrada')->unsigned();
            $table->foreign('id_entrada')->references('id')->on('entradas');
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
        Schema::dropIfExists('detalle_entradas');
    }
}
