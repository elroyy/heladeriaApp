<?php

namespace App\Http\Controllers;
use App\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
    
        $buscar= $request->buscar;
        $criterio= $request->criterio;
        // $productos = Productos::orderBy('nombre', 'asc')->get();
        if($buscar==''){
            $productos= Productos::select('productos.id',
            'productos.nombre',            
            'productos.marca',
            'productos.stock',
            'productos.precio')
            ->orderBy('productos.nombre', 'asc')->paginate(3);
        } else{
            $productos = Productos::select('productos.id',
            'productos.nombre',            
            'productos.marca',
            'productos.stock',
            'productos.precio')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.nombre', 'asc')->paginate(3);
        } 
        return[

            'pagination' => [
            'total'            => $productos->total(),
            'current_page'     => $productos->currentPage(),
            'per_page'         => $productos->perPage(),
            'last_page'        => $productos->lastPage(),
            'from'             => $productos->firstItem(),
            'to'               => $productos->lastItem(),           
            ],

            'productos' =>$productos

        ];
    }
    public function listarProducto(Request $request)
    {
        

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $productos = Productos::select('productos.id',                      
            'productos.nombre',
            'productos.marca',
            'productos.stock',            
            'productos.precio')
            ->orderBy('productos.id', 'asc')->paginate(10);
        }
        else{
            $productos = Productos::select('productos.id',                      
            'productos.nombre',
            'productos.marca',
            'productos.stock',            
            'productos.precio')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'asc')->paginate(10);
        }
        

        return ['productos' => $productos];
    }
    
    public function store(Request $request)
    {
        $productos= new Productos();        
        $productos->nombre = $request->nombre;
        $productos->marca = $request->marca;
        $productos->stock = $request->stock;
        $productos->precio= $request->precio;    
        $productos->save();
    }
    
    public function update(Request $request)
    {
        
        $productos= Productos::findOrFail($request->id);

        $productos->nombre = $request->nombre;
        $productos->marca = $request->marca;
        $productos->stock = $request->stock;
        $productos->precio= $request->precio;
        $productos->save();
    }
    
    public function destroy(Request $request)
    {
        $productos = Productos::findOrFail($request->id);
        $productos->delete();
    }
    public function buscarProducto(Request $request)
    {
        

        $filtro = $request->filtro;
        $productos = Productos::where('nombre','=', $filtro)
        // ->orwhere('nombre','=',$filtro)
        ->select('id','nombre')->orderBy('nombre', 'asc')->take(1)->get(); //take solo toma un valor
        
        return ['productos' => $productos];
    }
    
    public function buscarProductoVenta(Request $request)
    {
        
        $filtro = $request->filtro;
        $productos = Productos::where('nombre','=', $filtro)
        ->select('id','nombre','stock','marca')
        ->where('stock','>','0')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();
        
        return ['productos' => $productos];
    }
        public function listarProductoVenta(Request $request)
    {
     

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $productos = Productos::select('productos.id',
            'productos.nombre',
            'productos.marca',
            'productos.stock',
            'productos.precio')
            ->orderBy('productos.id', 'asc')->paginate(10);
        }
        else{
            $productos = Productos::select('productos.id',
            'productos.nombre',
            'productos.marca',
            'productos.stock',
            'productos.precio')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.id', 'asc')->paginate(10);
        }
        return ['productos' => $productos];
    }
}    
