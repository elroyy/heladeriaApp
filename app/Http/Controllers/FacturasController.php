<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Facturas;
use App\DetalleFacturas;
use App\User;
// use App\Notifications\NotifyAdmin;

class FacturasController extends Controller
{
    public function index(Request $request){

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $facturas = Facturas::join('clientes','facturas.id_cliente','=','clientes.id')
            ->join('users','facturas.id_usuario','=','users.id')
            ->select('facturas.id','facturas.num_fac','facturas.fecha_hora','facturas.iva','facturas.total',
            'facturas.estado','clientes.nomCom','users.usuario')
            ->orderBy('facturas.id', 'asc')->paginate(3);
        }
        else{
            $facturas = Facturas::join('clientes','facturas.id_cliente','=','clientes.id')
            ->join('users','facturas.id_usuario','=','users.id')
            ->select('facturas.id','facturas.num_fac','facturas.fecha_hora','facturas.iva','facturas.total',
            'facturas.estado','clientes.nomCom','users.usuario')
            ->where('facturas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('facturas.id', 'asc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $facturas->total(),
                'current_page' => $facturas->currentPage(),
                'per_page'     => $facturas->perPage(),
                'last_page'    => $facturas->lastPage(),
                'from'         => $facturas->firstItem(),
                'to'           => $facturas->lastItem(),
            ],
            'facturas' => $facturas
        ];
    }
    public function obtenerDatos(Request $request){

        $id = $request->id;
        $facturas = Facturas::join('clientes','facturas.id_cliente','=','clientes.id')
        ->join('users','facturas.id_usuario','=','users.id')       
        ->select('facturas.id','facturas.num_fac','facturas.fecha_hora','facturas.iva','facturas.total',
        'facturas.estado','clientes.nombre','users.usuario')
        ->where('facturas.id','=',$id)
        ->orderBy('facturas.id', 'asc')->take(1)->get();
        
        return ['facturas' => $facturas];
    }
    public function obtenerDetalles(Request $request){        

        $id = $request->id;
        $detalles = DetalleFacturas::join('productos','detalle_facturas.id_producto','=','productos.id')
        ->select('detalle_facturas.cantidad','detalle_facturas.precio',
        'productos.nombre as producto')
        ->where('detalle_facturas.id_factura','=',$id)
        ->orderBy('detalle_facturas.id', 'asc')->get();
        
        return ['detalles' => $detalles];
    }
    public function store(Request $request){
        // if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/Bogota');
            $facturas = new Facturas();
            $facturas->id_cliente = $request->id_cliente;
            $facturas->id_usuario = \Auth::user()->id;
            $facturas->num_fac = $request->num_fac;
            $facturas->fecha_hora = $mytime->toDateString();
            $facturas->iva = $request->iva;
            $facturas->total = $request->total;
            $facturas->estado = 'Registrado';
            $facturas->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleFacturas();
                $detalle->id_factura = $facturas->id;
                $detalle->id_producto = $det['id_producto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];   
                $detalle->save();
            }          

            $fechaActual= date('Y-m-d');
            $numfacturas = DB::table('facturas')->whereDate('created_at', $fechaActual)->count(); 
            $numEntradas = DB::table('detalle_facturas')->whereDate('created_at',$fechaActual)->count(); 

            $arregloDatos = [ 
            'facturas' => [ 
                        'numero' => $numfacturas, 
                        'msj' => 'facturas' 
                    ], 
            'detalle_facturas' => [ 
                        'numero' => $numEntradas, 
                        'msj' => 'detalle_facturas' 
                    ] 
            ];                
            $allUsers = User::all();

            DB::commit();
            return [
                'id' => $facturas->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request){        
        $facturas = Facturas::findOrFail($request->id);
        $facturas->estado = 'Anulado';
        $facturas->save();
    }
}
