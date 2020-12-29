<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('contenido/contenido');
// });

Route::group(['middleware' => ['guest']], function () { //Para los que no se autentican
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});


Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    // Route::get('/dashboard', 'DashboardController');---prueba u,u

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Vendedor']], function () {

        Route::get('/cliente', 'ClientesController@index');
        Route::get('/cliente/selectCliente', 'ClientesController@selectCliente');
        Route::post('/cliente/registrar', 'ClientesController@store');
        Route::put('/cliente/actualizar', 'ClientesController@update');
        Route::post('/cliente/eliminar', 'ClientesController@destroy');


        Route::get('/factura', 'FacturasController@index');
        Route::post('/factura/registrar', 'FacturasController@store');
        Route::put('/factura/desactivar', 'FacturasController@desactivar');
        Route::get('/factura/obtenerDatos', 'FacturasController@obtenerDatos');
        Route::get('/factura/obtenerDetalles', 'FacturasController@obtenerDetalles');


        Route::get('/producto', 'ProductosController@index');
        Route::get('/producto/buscarProducto', 'ProductosController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductosController@listarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductosController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductosController@listarProductoVenta');
        Route::post('/producto/registrar', 'ProductosController@store');
        Route::post('/producto/eliminar', 'ProductosController@destroy');
        Route::put('/producto/actualizar', 'ProductosController@update');
    });
    Route::group(['middleware' => ['Administrador']], function () {

        Route::get('/cliente', 'ClientesController@index');
        Route::get('/cliente/selectCliente', 'ClientesController@selectCliente');
        Route::post('/cliente/registrar', 'ClientesController@store');
        Route::put('/cliente/actualizar', 'ClientesController@update');
        Route::post('/cliente/eliminar', 'ClientesController@destroy');
        
        Route::get('/sucursal', 'SucursalesController@index');
        Route::get('/sucursal/selectSucursal', 'SucursalesController@selectSucursal');
        Route::post('/sucursal/registrar', 'SucursalesController@store');
        Route::put('/sucursal/actualizar', 'SucursalesController@update');
        Route::post('/sucursal/eliminar', 'SucursalesController@destroy');

        Route::get('/factura', 'FacturasController@index');
        Route::post('/factura/registrar', 'FacturasController@store');
        Route::put('/factura/desactivar', 'FacturasController@desactivar');
        Route::get('/factura/obtenerDatos', 'FacturasController@obtenerDatos');
        Route::get('/factura/obtenerDetalles', 'FacturasController@obtenerDetalles');

        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');   
        Route::post('/user/eliminar', 'UserController@destroy');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        Route::get('/rol', 'RolesController@index');
        Route::get('/rol/selectRol', 'RolesController@selectRol');

        Route::get('/producto', 'ProductosController@index');
        Route::get('/producto/buscarProducto', 'ProductosController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductosController@listarProducto');
        Route::get('/producto/buscarProductoVenta', 'ProductosController@buscarProductoVenta');
        Route::get('/producto/listarProductoVenta', 'ProductosController@listarProductoVenta');
        Route::post('/producto/registrar', 'ProductosController@store');
        Route::post('/producto/eliminar', 'ProductosController@destroy');
        Route::put('/producto/actualizar', 'ProductosController@update');

        Route::get('/entrada', 'EntradasController@index');
        Route::get('/entrada/obtenerDatos', 'EntradasController@obtenerDatos');
        Route::get('/entrada/obtenerDetalles', 'EntradasController@obtenerDetalles');
        Route::post('/entrada/registrar', 'EntradasController@store');
        Route::put('/entrada/desactivar', 'EntradasController@desactivar');

        Route::get('proveedor', 'ProveedoresController@index');
        Route::get('proveedor/selectProveedor', 'ProveedoresController@selectProveedor');
        Route::post('/proveedor/registrar', 'ProveedoresController@store');
        Route::put('proveedor/actualizar', 'ProveedoresController@update');
        Route::post('/proveedor/eliminar', 'ProveedoresController@destroy');
    });


});
