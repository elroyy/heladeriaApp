<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entradas extends Model
{ 
        protected $fillable = [
            'num_fac',
            'fecha_hora',
            'iva',
            'total',
            'estado',
            'id_proveedor', 
            'id_usuario'
        ];
        
        public function usuario() //Trae usuario que a registrado entrada del producto
        {
            return $this->belongsTo('App\User');
        }

        public function proveedor() //Trae el proveedor que ha suministrado el producto
        {
            return $this->belongsTo('App\Proveedores');
        }
    }
