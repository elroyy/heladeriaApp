<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre','tipo_documento','num_documento','direccion','telefono','email','id_ciudad'];

    public function provedores()
    {
        return $this->hasOne('App\Proveedores');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }


}