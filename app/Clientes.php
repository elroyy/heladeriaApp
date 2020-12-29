<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable=[
        'id','nombre','apellido','tipo_documento','num_documento','direccion',
        'telefono','email','nomCom'];
        public $timestamps=false;
}
