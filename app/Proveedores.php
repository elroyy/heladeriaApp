<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $fillable=[
    'id','nombre','apellido','tipo_documento','num_documento','direccion',
    'telefono','email','nomCom'];
}