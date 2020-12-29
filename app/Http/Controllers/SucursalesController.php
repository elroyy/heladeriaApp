<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sucursales;
class SucursalesController extends Controller
{
    public function index(Request $request)
    {
        $buscar   = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $sucursales = Sucursales::select('sucursales.id',
            'sucursales.nombre',            
            'sucursales.direccion',
            'sucursales.telefono',
            'sucursales.email',
            'sucursales.ciudad',
            ) 
            ->orderBy('nombre','asc')->paginate(2);
        } else {
            $sucursales = Sucursales::select('sucursales.id',
            'sucursales.nombre',            
            'sucursales.direccion',
            'sucursales.telefono',
            'sucursales.email',
            'sucursales.ciudad',)  
            
            ->where('sucursales.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $sucursales->total(),
                'current_page' => $sucursales->currentPage(),
                'per_page'     => $sucursales->perPage(),
                'last_page'    => $sucursales->lastPage(),
                'from'         => $sucursales->firstItem(),
                'to'           => $sucursales->lastItem(),

            ],
            'sucursales'  => $sucursales,
        ];
    }

    
    public function selectSucursal(Request $request){
    $filtro = $request->filtro;
    $sucursales = Sucursales::where('nombre', 'like', '%'. $filtro . '%')
    ->orWhere('nombre', 'like', '%'. $filtro . '%')
    ->select('id','nombre')
    ->orderBy('nombre', 'asc')->get();

    return ['sucursales' => $sucursales];
}

    public function store(Request $request)
    {
        $sucursales         = new Sucursales();
        $sucursales->nombre = $request->nombre;
        $sucursales->direccion = $request->direccion;
        $sucursales->email = $request->email;
        $sucursales->telefono = $request->telefono;
        $sucursales->ciudad = $request->ciudad;        
        $sucursales->save();
    }

    public function update(Request $request)
    {
        $sucursales         = Sucursales::findOrFail($request->id);
        $sucursales->nombre = $request->nombre;
        $sucursales->direccion = $request->direccion;
        $sucursales->email = $request->email;
        $sucursales->telefono = $request->telefono;
        $sucursales->ciudad = $request->ciudad; 
        $sucursales->save();
    }
    public function destroy(Request $request)
    {
        $sucursales = Sucursales::findOrFail($request->id);
        $sucursales->delete();
    }
}



