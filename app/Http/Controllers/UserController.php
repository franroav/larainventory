<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;
use App\Http\Requests;
//Traemos la libreria de la base de datos con el query builder
use Illuminate\Support\Facades\DB;
//Traemos el modelo de Usuarios 
use App\User;

class UserController extends Controller
{
	//metodo para el registro de usuarios , vienen las variables por POST
	public function register(Request $request)
	{

		//El objeto json es enviado por params, json = {New User object};
		$json = $request->input('json', null);
		//convertir el json en un objeto;
		$params = json_decode($json);

		//CONDICION TERNARIA, Para validar los datos del nuevo usuario 

		$email = (!is_null($json)) && isset($params->email) ? $params->email : null;
		$name = (!is_null($json)) && isset($params->name) ? $params->name : null;
		$surname = (!is_null($json)) && isset($params->surname) ? $params->surname : null;
		$role = 'ROLE_USER';
		$password = (!is_null($json)) && isset($params->password) ? $params->password : null;

		if (!is_null($email) && !is_null($password) && !is_null($name)) {

			//Crear el Usuario, instacio el objeto del modelo y guardo mi nuevo objeto
			$user = new User();
			$user->role = $role;
			$user->name = $name;
			$user->surname = $surname;
			$user->email = $email;
			//metodo hash para encriptar la clave php;
			$pwd = hash('sha256', $password);
			$user->password = $pwd;

			//comprobar usuario duplicado 
			$isset_user = User::where('email', '=', $email)->first();

			if (!is_object($isset_user)) {

				//guardar el usuario 
				$user->save();

				//mensaje con condigo 200 success
				$data = array(
					'status' => 'success',
					'code' => 200,
					'message' => 'Usuario Registrado Correctamente'
				);
			} else {
				//Mensaje que no ha guardado Porque ya existe el registro con code 300
				$data = array(
					'status' => 'error',
					'code' => 300,
					'message' => 'Usuario duplicado, no puede registrarse'
				);
			}
		} else {
			$data = array(
				'status' => 'error',
				'code' => 400,
				'message' => 'Usuario no creado'
			);
		}

		return response()->json($data, 200);
	}

	public function login(Request $request)
	{
		//importar helper JWT
		$jwtAuth = new JwtAuth();

		//recibir los datos por POST
		$json = $request->input('json', null);

		$params = json_decode($json);

		//var_dump($params); die();
		//dd($params);

		//condicion ternaria
		$email = (!is_null($json) && isset($params->email)) ? $params->email : null;
		$password = (!is_null($json) && isset($params->password)) ? $params->password : null;
		$getToken = (!is_null($json) && isset($params->gettoken)) ? $params->gettoken : null;

		//Cifrar la password
		$pwd = hash('sha256', $password);

		if (!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false')) {

			$signup = $jwtAuth->signup($email, $pwd);
		} elseif ($getToken != null) {
			//var_dump($getToken); die();
			$signup = $jwtAuth->signup($email, $pwd, $getToken);
		} else {

			$signup = array(
				'status' => 'error',
				'message' => 'Envia tus datos por post'
			);
		}

		return response()->json($signup, 200);
	}
}
