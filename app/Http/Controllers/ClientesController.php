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
use App\Clientes;
use App\Helpers\JwtAuth;

class ClientesController extends Controller
{
    //LISTADO GLOBAL DE TODOS LOS CLIENTES
    public function index(Request $request)
    {

        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            $clientes = Clientes::all();
            return response()->json(array(
                'productos' => $clientes,
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

    //CREAR INSTALADOR // GUARDAR 
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

            /*validación , la funcion validate necesita un array , no un json.*/
            $validate = \Validator::make($params_array, [
                'nombre' =>
                'required|min:3',
                'documento' => 'required',
                'email' => 'required',
                'telefono' => 'required'
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            $cliente = new Clientes();
            $cliente->nombre = $params->nombre;
            $cliente->documento = $params->documento;
            $cliente->email = $params->email;
            $cliente->telefono = $params->telefono;
            $cliente->direccion = $params->direccion;
            $cliente->fecha = $params->fecha;
            $cliente->save();

            //si la autenticación es exitosa devuelve el objeto data

            $data = array(
                'cliente' => $cliente,
                'status' => 'success',
                'code' => 200,
            );
        } else {

            //Devolver un Error

            $data = array(
                'message' => 'Algo salio mal.. Porfavor intentelo nuevamente!',
                'status' => 'error',
                'code' => 400
            );
        }

        return response()->json($data, 200);
    }

    //EDITAR // ACTUALIZAR INSTALADOR 

    public function update($id, Request $request)
    {

        //autenticación
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            //Recoger parametros por POST
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

            //validación , la funcion validate necesita un array , no un json.
            $validate = \Validator::make($params_array, [
                'nombre' =>
                'required|min:3',
                'documento' => 'required',
                'email' => 'required',
                'telefono' => 'required'
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            //buscar el registro
            $cliente = Clientes::where('id', $id)->update($params_array);

            //devuelve el objeto data
            $data = array(
                'cliente' => $cliente,
                'status' => 'success',
                'code' => 200,
            );
        } else {

            //Devolver un Error

            $data = array(
                'message' => 'Operacion Incorrecta! intentelo nuevamente.',
                'status' => 'error',
                'code' => 300
            );

            die();
        }

        return response()->json($data, 200);
    }

    //SHOW

    public function show($id)
    {
        $cliente = Clientes::find($id);
        return response()->json(
            array(
                'cliente' => $cliente,
                'status' => 'success'
            ),
            200
        );
    }

    //DESTROY // ELIMINAR CLIENTES

    public function destroy(Request $request, $id)
    {
        //Autorizacion
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            //Comprobar que existe el registro 
            // METODO FIND 
            $cliente = Clientes::find($id);

            //Borrarlo
            $cliente->delete();

            //Devolverlo
            $data = array(
                'message' => $cliente,
                'status' => 'success',
                'code' => 200
            );
        } else {

            $data = array(
                'message' => 'Operación Incorrecta! intentar nuevamente.',
                'status' => 'success',
                'code' => 300,
            );
        }

        return response()->json($data, 200);
    }
}
