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
use App\Proveedor;
use App\Helpers\JwtAuth;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {

        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            $proveedor = Proveedor::all();
            return response()->json(array(
                'proveedor' => $proveedor,
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

    //CREAR PROVEEDOR // GUARDAR 
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

            $validate = \Validator::make($params_array, [
                'nombre' => 'required',
                'documento' => 'required',
                'email' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                'tipo_cuenta' => 'required',
                'nro_cuenta' => 'required',
                'tipo_banco' => 'required',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            $proveedor = new Proveedor();
            $proveedor->nombre = $params->nombre;
            $proveedor->documento = $params->documento;
            $proveedor->email = $params->nombre;
            $proveedor->telefono = $params->documento;
            $proveedor->direccion = $params->nombre;
            $proveedor->tipo_cuenta = $params->documento;
            $proveedor->nro_cuenta = $params->nombre;
            $proveedor->fecha_dia = $params->fecha;
            $proveedor->save();

            //devuelve el objeto data

            $data = array(
                'proveedor' => $proveedor,
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

    //EDITAR // ACTUALIZAR PROVEEDOR 

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

            //Validacion de datos 
            //validación , la funcion validate necesita un array , no un json.
            $validate = \Validator::make($params_array, [
                'nombre' => 'required',
                'documento' => 'required',
                'email' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                'tipo_cuenta' => 'required',
                'nro_cuenta' => 'required',
                'tipo_banco' => 'required',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            $proveedor = Proveedor::where('id', $id)->update($params_array);

            //devuelve el objeto data

            $data = array(
                'proveedor' => $proveedor,
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
        $proveedor = Proveedor::find($id);
        return response()->json(
            array(
                'proveedor' => $proveedor,
                'status' => 'success'
            ),
            200
        );
    }

    //DESTROY // ELIMINAR INSTALADOR

    public function destroy(Request $request, $id)
    {
        //Autorizacion
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            //Comprobar que existe el registro 
            $proveedor = Proveedor::find($id);

            //Borrarlo
            $proveedor->delete();

            //Devolverlo
            $data = array(
                'message' => $proveedor,
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
