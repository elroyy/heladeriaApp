<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Persona;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.id_rol','=','roles.id')
             ->join('sucursales','personas.id_sucursal','=','sucursales.id')
            ->select('personas.id',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'personas.id_sucursal',
            'users.usuario',
            'users.password',
            'users.id_rol',
            'roles.nombre as rol',
            'sucursales.nombre as sucursal')
            ->orderBy('personas.id', 'asc')->paginate(3);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.id_rol','=','roles.id')
             ->join('sucursales','personas.id_sucursal','=','sucursales.id')
            ->select('personas.id',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'personas.id_sucursal',
            'users.usuario',
            'users.password',
            'users.id_rol',
            'roles.nombre as rol',
            'sucursales.nombre as sucursal')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'asc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {

        try{
            DB::beginTransaction();

            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
             $persona->id_sucursal = $request->id_sucursal;
            $persona->save();

            $user = new User();
            $user->id = $persona->id;
            $user->id_rol = $request->id_rol;
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);            
            $user->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {

        try{
            DB::beginTransaction();
            $user = User::findOrFail($request->id);
            $persona = Persona::findOrFail($user->id);
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
             $persona->id_sucursal = $request->id_sucursal;
            $persona->save();            

            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->id_rol = $request->id_rol;
            $user->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
    }
}
