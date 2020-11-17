<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App\Helpers;

use Firebase\JWT\JWT;
//QUERY BUILDER
use Illuminate\Support\Facades\DB;
//MODELO USER
use App\User;

//EN los helpers se crea un provider, luego en config app, registrar un services y luego un alias 

class JwtAuth
{

	public $key;

	public function __construct()
	{

		$this->key = env('KEY_PASSWORD_SECRET');
	}

	public function signup($email, $password, $getToken = null)
	{
		//sacame todos los usuarios cuyo email y passwors coincidan con los que llegan 

		$user = User::where(
			array(
				'email' => $email,
				'password' => $password
			)
		)->first(); // me devuelve solo uno el primero 

		// la variable signup viene falso por defecto.  
		//y su viene un objeto del usuario, user, es un objeto cambiamelo a true 
		$signup = false;

		if (is_object($user)) {
			$signup = true;
		}

		if ($signup) {
			// generar el token y devolverlo 

			$token = array(
				'sub' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'surname' => $user->surname,
				'iat' => time(),
				'exp' => time() + (7 * 24 * 60 * 60)
			);
			//web token cifrado
			$jwt = JWT::encode($token, $this->key, 'HS256');
			$decoded = JWT::decode($jwt, $this->key, array('HS256'));

			if (!is_null($getToken)) {
				return $jwt;
			} else {
				return $decoded;
			}
		} else {
			// Devolver un error

			return array(
				'status' => 'error',
				'message' => 'el login a fallado!!'
			);
		}
	}

	public function checkToken($jwt, $getIdentity = false)
	{

		$auth = false;

		try {

			$decoded = JWT::decode($jwt, $this->key, array('HS256'));
		} catch (\UnexpectedValueException $e) {
			$auth = false;
		} catch (\DomainException $e) {
			$auth = false;
		}

		if (isset($decoded) && is_object($decoded) && isset($decoded->sub)) {
			$auth = true;
		} else {
			$auth = false;
		}

		if ($getIdentity) {

			return $decoded;
		}

		return $auth;
	}
}
