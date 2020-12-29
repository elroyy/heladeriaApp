<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('tipo_documento', 20)->nullable();
            $table->string('num_documento', 20)->nullable();
            $table->string('direccion',100);
            $table->string('telefono',10);
            $table->string('nombre_comercial',100)->nullable();
            $table->string('telefono_contacto',50)->nullable(); 
        
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
        Schema::dropIfExists('proveedores');
    }
}
