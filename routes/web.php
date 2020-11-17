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

Route::get('/', function () {
    return view('welcome');
});

/**RUTAS , PARAMETROS, CONTROLADORES , NAMES  */

/**
 * controlador PARA REGISTER
 */
Route::post('/api/register', 'UserController@register')->name('register'); // ejecuta el metodo register
/**
 * controlador PARA LOGIN
 */
Route::post('/api/login', 'UserController@login')->name('login'); // ejecuta el metodo login
/**
 * controlador RESTFULL PARA CARS
 */
Route::resource('/api/cars', 'CarController');
/**
 * controlador RESTFULL PARA INSTALADORES 
 */
Route::resource('/api/instaladores', 'InstaladorController');
/**
 * controlador RESTFULL PARA PRODUCTOS
 */
Route::resource('/api/productos', 'ProductoController');
/**
 * controlador RESTFULL PARA CATEGORIAS 
 */
Route::resource('/api/categorias', 'CategoriaController');
/**
 * controlador RESTFULL PARA COTIZACIONES 
 */
Route::resource('/api/cotizaciones', 'CotizacionController');
/**
 * controlador RESTFULL PARA VENTAS
 */
Route::resource('/api/ventas', 'VentasController');
/**
 * controlador RESTFULL PARA CLIENTES
 */
Route::resource('/api/clientes', 'ClientesController');
/**
 * controlador RESTFULL PARA INSTALADORES 
 */
Route::resource('/api/pedidos', 'PedidosController');
/**
 * controlador RESTFULL PARA INSTALADORES 
 */
Route::resource('/api/proveedor', 'ProveedorController');

//GET SERVICE HTTP CLIENT
Route::get('/api/service', 'ServiceController@index');
