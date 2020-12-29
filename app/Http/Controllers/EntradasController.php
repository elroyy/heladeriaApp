<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Entradas;
use App\DetalleEntradas;
use App\User; 
class EntradasController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $entradas = Entradas::join('proveedores','entradas.id_proveedor','=','proveedores.id')
            ->join('users','entradas.id_usuario','=','users.id')
            ->select('entradas.id', 'entradas.num_fac','entradas.fecha_hora','entradas.iva','entradas.total',
            'entradas.estado','proveedores.nombre as proveedor','proveedores.nomCom','users.usuario')
            ->orderBy('entradas.fecha_hora', 'asc')->paginate(3);
        }
        else{
            $entradas = Entradas::join('proveedores','entradas.id_proveedor','=','proveedores.id')
            ->join('users','entradas.id_usuario','=','users.id')
            ->select('entradas.id', 'entradas.num_fac','entradas.fecha_hora','entradas.iva','entradas.total',
            'entradas.estado','proveedores.nombre as proveedor','proveedores.nomCom','users.usuario')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('fecha_hora', 'asc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $entradas->total(),
                'current_page' => $entradas->currentPage(),
                'per_page'     => $entradas->perPage(),
                'last_page'    => $entradas->lastPage(),
                'from'         => $entradas->firstItem(),
                'to'           => $entradas->lastItem(),
            ],
            'entradas' => $entradas
        ];
    } 
    public function obtenerDatos(Request $request){

        $id = $request->id;
        $entradas = Entradas::join('proveedores','entradas.id_proveedor','=','proveedores.id')
        ->join('users','entradas.id_usuario','=','users.id')
        ->select('entradas.id',
        'entradas.num_fac',
        'entradas.fecha_hora',
        'entradas.iva',
        'entradas.total',
        'entradas.estado',
        'proveedores.nombre',
        'users.usuario')
        ->where('entradas.id','=',$id)
        ->orderBy('entradas.id', 'desc')->take(1)->get();
        
        return ['entradas' => $entradas];

    }
    public function obtenerDetalles(Request $request){

        $id = $request->id;
        $detalle_entradas = DetalleEntradas::join('productos','detalle_entradas.id_producto','=','productos.id')
        ->select('detalle_entradas.cantidad','detalle_entradas.precio','productos.nombre as producto')
        ->where('detalle_entradas.id_entrada','=',$id)
        ->orderBy('detalle_entradas.id', 'desc')->get();
        
        return ['detalle_entradas' => $detalle_entradas];
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $mytime= Carbon::now('America/Bogota');
            $entradas = new Entradas();
            $entradas->num_fac = $request->num_fac;
            $entradas->fecha_hora = $mytime->toDateString();  //captura fecha y hora actual
            $entradas->iva = $request->iva;
            $entradas->total = $request->total;
            $entradas->estado = 'Registrada';
            $entradas->id_proveedor = $request->id_proveedor;
            $entradas->id_usuario = \Auth::user()->id;
            $entradas->save();
            
            $detalles = $request->data; //Array de los detalles
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleEntradas();
                $detalle->id_entrada = $entradas->id;
                $detalle->id_producto = $det['id_producto'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
            } 
            DB::commit();
        } catch(Exception $e){
            DB::rollback();
        
        }
    }

    public function desactivar(Request $request)
    {
        $entradas = Entradas::findOrFail($request->id);
        $entradas->estado = 'Anulada';
        $entradas->save();
    }

}
