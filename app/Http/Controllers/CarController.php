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
use App\Helpers\JwtAuth;
use App\Car;

class CarController extends Controller
{
	public function index(Request $request)
	{
		//Traemos todos los VEHICULOS
		$cars = Car::all();

		return response()->json(array(
			'cars' => $cars,
			'status' => 'success'
		), 200);
	}

	public function show($id)
	{
		// load user carga el usuario contendio en la consulta.
		$car = Car::find($id)->load('user');
		return response()->json(array(
			'car' => $car,
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
				'title' => 'required|min:5',
				'description' => 'required',
				'price' => 'required',
				'status' => 'required'
			]);

			//Capturar errores
			if ($validate->fails()) {

				return response()->json($validate->errors(), 400);
			}

			//Actualizar el Registro
			//buscar el registro
			$car = Car::where('id', $id)->update($params_array);

			$data = array(
				'car' => $params,
				'status' => 'success',
				'code' => 200
			);
		} else {

			//Devolver un Error

			$data = array(
				'car' => 'Login Incorrecto',
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

		//var_dump($checkToken); die();

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
				'title' => 'required|min:5',
				'description' => 'required',
				'price' => 'required',
				'status' => 'required'
			]);

			//Capturar errores

			if ($validate->fails()) {

				return response()->json($validate->errors(), 400);
			}


			// Guardar el Coche
			$car = new Car();
			$car->user_id = $user->sub;
			$car->title = $params->title;
			$car->description = $params->description;
			$car->price = $params->price;
			$car->status = $params->status;

			$car->save();

			//si la autenticación es exitosa devuelve el objeto data

			$data = array(
				'car' => $car,
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

			$car = Car::find($id);

			//Borrarlo
			$car->delete();

			//Devolverlo
			$data = array(
				'car' => $car,
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
