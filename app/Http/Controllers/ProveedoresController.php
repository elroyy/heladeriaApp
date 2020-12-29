<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedores;


class ProveedoresController extends Controller
{
   
    public function index(Request $request)
    {
        $buscar   = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $proveedores = Proveedores::select('proveedores.id',
            'proveedores.nombre',
            'proveedores.apellido',
            'proveedores.num_documento',
            'proveedores.tipo_documento',
            'proveedores.direccion',
            'proveedores.telefono',
            'proveedores.nombre_comercial',
            'proveedores.telefono_contacto',
           ) 
            ->orderBy('nombre','asc')->paginate(2);
        } else {
            $proveedores = Proveedores::select('proveedores.id',
            'proveedores.nombre',
            'proveedores.apellido',
            'proveedores.num_documento',
            'proveedores.tipo_documento',
            'proveedores.direccion',
            'proveedores.telefono',
            'proveedores.nombre_comercial',
            'proveedores.telefono_contacto',
           )  
            
            ->where('proveedores.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $proveedores->total(),
                'current_page' => $proveedores->currentPage(),
                'per_page'     => $proveedores->perPage(),
                'last_page'    => $proveedores->lastPage(),
                'from'         => $proveedores->firstItem(),
                'to'           => $proveedores->lastItem(),

            ],
            'proveedores'  => $proveedores,
        ];
    }

    public function selectProveedor(Request $request){
    $filtro = $request->filtro;
    $proveedores = Proveedores::where('nombre', 'like', '%'. $filtro . '%')
    ->orWhere('num_documento', 'like', '%'. $filtro . '%')
    ->select('id','nombre','num_documento','nomCom')
    ->orderBy('nombre', 'asc')->get();

    return ['proveedores' => $proveedores];
}

    public function store(Request $request)
    {
        $proveedores         = new proveedores();
        $proveedores->nombre = $request->nombre;
        $proveedores->apellido = $request->apellido;        
        $proveedores->tipo_documento = $request->tipo_documento;
        $proveedores->num_documento = $request->num_documento;
        $proveedores->direccion = $request->direccion;
        $proveedores->telefono = $request->telefono;
        $proveedores->nombre_comercial = $request->nombre_comercial;
        $proveedores->telefono_contacto = $request->telefono_contacto;
        $proveedores->save();
    }

    public function update(Request $request)
    {
        $proveedores         = Proveedores::findOrFail($request->id);
        $proveedores->nombre = $request->nombre;
        $proveedores->apellido = $request->apellido; 
        $proveedores->tipo_documento = $request->tipo_documento;
        $proveedores->num_documento = $request->num_documento;
        $proveedores->direccion = $request->direccion;
        $proveedores->telefono = $request->telefono;
        $proveedores->nombre_comercial = $request->nombre_comercial;
        $proveedores->telefono_contacto = $request->telefono_contacto;
        $proveedores->save();
    }
    public function destroy(Request $request)
    {
        $proveedores = Proveedores::findOrFail($request->id);
        $proveedores->delete();
    }
}
