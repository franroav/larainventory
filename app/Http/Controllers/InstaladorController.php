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
use App\Instalador;
// helper 
use App\Helpers\JwtAuth;

class InstaladorController extends Controller
{
    //LISTADO GLOBAL DE TODOS LOS INSTALADORES
    public function index(Request $request)
    {

        /**
         * INSTALADORES 
         * */
        $instaladores = Instalador::all()->load('user');
        return response()->json(array(
            'instaladores' => $instaladores,
            'status' => 'success'
        ), 200);

        // header Authorization => token
        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            echo "index de InstaladoresController";
            die();
        } else {

            echo "acción registro";
            die();
        }
    }

    //CREAR INSTALADOR // GUARDAR 
    public function store(Request $request)
    {


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
                'especialidad' => 'required|min:5',
                'curriculum' => 'required',
                'entregable' => 'required',
                'precio' => 'required',
                'estado' => 'required'
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }


            // Guardar el Instalador
            $instalador = new Instalador();
            $instalador->user_id = $user->sub;
            $instalador->especialidad = $params->especialidad;
            $instalador->curriculum = $params->curriculum;
            $instalador->entregable = $params->entregable;
            $instalador->precio = $params->precio;
            $instalador->estado = $params->estado;
            $instalador->save();

            //devuelveme el objeto con codigo 200
            $data = array(
                'instalador' => $instalador,
                'status' => 'success',
                'code' => 200,
            );
        } else {

            //Devolver un Error

            $data = array(
                'message' => 'instalador Incorrecto',
                'status' => 'error',
                'code' => 300
            );

            echo 'No Autenticado store -> Index de InstaladorController';
            die();
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
                'especialidad' => 'required|min:5',
                'curriculum' => 'required',
                'entregable' => 'required',
                'precio' => 'required',
                'estado' => 'required'
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            $instalador = Instalador::where('id', $id)->update($params_array);

            //devuelve el objeto data con codigo 200
            $data = array(
                'instalador' => $instalador,
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

            echo 'No Autenticado store -> Index de InstaladorController';
            die();
        }

        return response()->json($data, 200);
    }

    //SHOW

    public function show($id)
    {
        // load user carga el usuario contendio en la consulra.
        $instalador = Instalador::find($id)->load('user');
        return response()->json(
            array(
                'instalador' => $instalador,
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
            $instalador = Instalador::find($id);

            //Borrarlo
            $instalador->delete();

            //Devolverlo
            $data = array(
                'message' => $instalador,
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
