<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
//JWT
use App\Helpers\JwtAuth;
//MODELO Cotizacion
use App\Cotizacion;

class CotizacionController extends Controller
{
	public function index(Request $request)
	{
		//Traemos todos las Cotizaciones 
		$hash = $request->header('Authorization', null);
		// intancio la clase jwtAuth();
		$jwtAuth = new jwtAuth();
		//llamo al metodo checkToken 
		$checkToken = $jwtAuth->checkToken($hash);

		if ($checkToken) {

			$cotizacion = Cotizacion::all();
			return response()->json(array(
				'cotizacion' => $cotizacion,
				'status' => 'success'
			), 200);
		} else {

			return response()->json(array(
				'message' => "Acceso restringido, Usuario No Identificado",
				'status' => 'error'
			), 300);
			die();
		}
	}

	public function show($id)
	{
		// load user carga el usuario contendio en la consulta.
		$cotizacion = Cotizacion::find($id);
		return response()->json(array(
			'cotizacion' => $cotizacion,
			'status' => 'success'
		), 200);
	}

	//actualizar editar
	public function update($id, Request $request)
	{

		//autenticación
		$hash = $request->header('Authorization', null);

		$jwtAuth = new JwtAuth();
		$checkToken = $jwtAuth->checkToken($hash);

		if ($checkToken) {

			//Actualizar el coche 

			//Recoger parametros por POST
			$json = $request->input('json', null);
			$params = json_decode($json);
			$params_array = json_decode($json, true);

			//Validacion de datos 
			//validación , la funcion validate necesita un array , no un json.
			$validate = \Validator::make($params_array, [
				'nombre' => 'required|min:5',
				'referencia' => 'required',
				'estado' => 'required',
				'nro_cotizacion' => 'required',
				'id_cliente' => 'required',
				'descripcion' => 'required'
			]);

			//Capturar errores

			if ($validate->fails()) {

				return response()->json($validate->errors(), 400);
			}

			//Actualizar el Registro
			//buscar el registro
			$cotizacion = Cotizacion::where('id', $id)->update($params_array);

			$data = array(
				'car' => $params,
				'status' => 'success',
				'code' => 200
			);
		} else {

			//Devolver un Error

			$data = array(
				'cotizacion' => 'Login Incorrecto',
				'status' => 'error',
				'code' => 300,
			);
		}

		return response()->json($data, 200);
	}

	public function store(Request $request)
	{

		//AUTENTICACION

		$hash = $request->header('Authorization', null);

		$jwtAuth = new JwtAuth();
		$checkToken = $jwtAuth->checkToken($hash);

		if ($checkToken) {
			//Recoger los datos por Post
			$json = $request->input('json', null);
			$params = json_decode($json);

			// convertir objeto json en un array pasandole el paramento true.
			$params_array = json_decode($json, true);

			//Conseguir el usuario Identificado    		
			$user = $jwtAuth->checkToken($hash, true);

			//validación , la funcion validate necesita un array , no un json.
			$validate = \Validator::make($params_array, [
				'nombre' => 'required|min:5',
				'referencia' => 'required',
				'estado' => 'required',
				'nro_cotizacion' => 'required',
				'id_cliente' => 'required',
				'descripcion' => 'required'
			]);

			//Capturar errores

			if ($validate->fails()) {

				return response()->json($validate->errors(), 400);
			}


			// Guardar el Coche

			//$user = $jwtAuth->checkToken($hash, true);
			$cotizacion = new Cotizacion();
			$cotizacion->nombre = $params->nombre;
			$cotizacion->referencia = $params->referencia;
			$cotizacion->estado = $params->estado;
			$cotizacion->nro_cotizacion = $params->nro_cotizacion;
			$cotizacion->id_cliente = $params->id_cliente;
			$cotizacion->description = $params->description;
			$cotizacion->save();

			//si la autenticación es exitosa devuelve el objeto data

			$data = array(
				'cotizacion' => $cotizacion,
				'status' => 'success',
				'code' => 200,
			);
		} else {

			//Devolver un Error

			$data = array(
				'car' => 'Login Incorrecto',
				'status' => 'success',
				'code' => 300,
			);

			echo 'No Autenticado store -> Index de CarController';
			die();
		}

		return response()->json($data, 200);
	}

	public function destroy(Request $request, $id)
	{
		//Autorizacion
		$hash = $request->header('Authorization', null);

		$jwtAuth = new JwtAuth();
		$checkToken = $jwtAuth->checkToken($hash);

		if ($checkToken) {
			//Comprobar que existe el registro 

			$cotizacion = Cotizacion::find($id);

			//Borrarlo
			$cotizacion->delete();

			//Devolverlo
			$data = array(
				'cotizacion' => $cotizacion,
				'status' => 'success',
				'code' => 200
			);
		} else {

			$data = array(
				'car' => 'Login Incorrecto',
				'status' => 'success',
				'code' => 300,
			);
		}

		return response()->json($data, 200);
	}
}
