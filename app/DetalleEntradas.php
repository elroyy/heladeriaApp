<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleEntradas extends Model
{
        protected $table = 'detalle_entradas';
        protected $fillable = [
            'cantidad',
            'precio',
            'id_producto',
            'id_entrada' 
        ];
    
    }
    
