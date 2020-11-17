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
use App\Pedidos;
// helper 
use App\Helpers\JwtAuth;

class PedidosController extends Controller
{
    //LISTADO GLOBAL DE TODOS LOS PEDIDOS
    public function index(Request $request)
    {
        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            $pedidos = Pedidos::all();
            return response()->json(array(
                'pedidos' => $pedidos,
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


            $validate = \Validator::make($params_array, [
                'tipo_pedido' => 'required',
                'numero_pedido' => 'required',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            $pedido = new Pedidos();
            $pedido->tipo_pedido = $params->tipo_pedido;
            $pedido->numero_pedido = $params->numero_pedido;
            $pedido->save();

            //devuelve el objeto data

            $data = array(
                'pedido' => $pedido,
                'status' => 'success',
                'code' => 200,
            );
        } else {

            $data = array(
                'message' => 'Algo salio mal.. Porfavor intentelo nuevamente!',
                'status' => 'error',
                'code' => 400
            );
        }

        return response()->json($data, 200);
    }

    //EDITAR // ACTUALIZAR PEDIDO

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
                'tipo_pedido' => 'required',
                'numero_pedido' => 'required',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            $pedido = Pedidos::where('id', $id)->update($params_array);

            // devuelve el objeto data
            $data = array(
                'pedido' => $pedido,
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
        $pedido = Pedidos::find($id);
        return response()->json(
            array(
                'pedido' => $pedido,
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
            // METODO FIND 
            $pedido = Pedidos::find($id);

            //Borrarlo
            $pedido->delete();

            //Devolverlo
            $data = array(
                'message' => $pedido,
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
