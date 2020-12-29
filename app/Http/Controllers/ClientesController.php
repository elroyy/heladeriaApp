<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;

class ClientesController extends Controller

{
    public function index(Request $request)
    {
        $buscar   = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $clientes = Clientes::select('clientes.id',
            'clientes.nombre',
            'clientes.apellido',
            'clientes.num_documento',
            'clientes.tipo_documento',
            'clientes.direccion',
            'clientes.telefono',
            'clientes.nomCom',
           ) 
            ->orderBy('nombre','asc')->paginate(2);
        } else {
            $clientes = Clientes::select('clientes.id',
            'clientes.nombre',
            'clientes.apellido',
            'clientes.num_documento',
            'clientes.tipo_documento',
            'clientes.direccion',
            'clientes.telefono',
            'clientes.nomCom',
           )  
            
            ->where('clientes.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $clientes->total(),
                'current_page' => $clientes->currentPage(),
                'per_page'     => $clientes->perPage(),
                'last_page'    => $clientes->lastPage(),
                'from'         => $clientes->firstItem(),
                'to'           => $clientes->lastItem(),

            ],
            'clientes'  => $clientes,
        ];
    }

    public function selectCliente(Request $request){
    $filtro = $request->filtro;
    $clientes = Clientes::where('nombre', 'like', '%'. $filtro . '%')
    ->orWhere('num_documento', 'like', '%'. $filtro . '%')
    ->select('id','nombre','num_documento','nomCom')
    ->orderBy('nombre', 'asc')->get();

    return ['clientes' => $clientes];
}

    public function store(Request $request)
    {
        $clientes         = new Clientes();
        $clientes->nombre = $request->nombre;
        $clientes->apellido = $request->apellido;        
        $clientes->tipo_documento = $request->tipo_documento;
        $clientes->num_documento = $request->num_documento;
        $clientes->direccion = $request->direccion;
        $clientes->telefono = $request->telefono;
        $clientes->save();
    }

    public function update(Request $request)
    {
        $clientes         = Clientes::findOrFail($request->id);
        $clientes->nombre = $request->nombre;
        $clientes->apellido = $request->apellido; 
        $clientes->tipo_documento = $request->tipo_documento;
        $clientes->num_documento = $request->num_documento;
        $clientes->direccion = $request->direccion;
        $clientes->telefono = $request->telefono;
        $clientes->save();
    }
    public function destroy(Request $request)
    {
        $clientes = Clientes::findOrFail($request->id);
        $clientes->delete();
    }
}
