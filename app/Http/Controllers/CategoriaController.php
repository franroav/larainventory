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
use App\Categoria;
use App\Helpers\JwtAuth;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::all();

        echo json_encode($categorias);

        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            $categorias = Categoria::all();
            return response()->json(array(
                'categorias' => $categorias,
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

    //CREAR CATEGORIA // GUARDAR 
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
                'categoria' => 'required|min:3',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            $categoria = new Categoria();
            $categoria->id = $params->id;
            $categoria->categoria = $params->categoria;
            $categoria->fecha = $params->fecha;
            $categoria->save();

            //si la autenticación es exitosa devuelve el objeto data

            $data = array(
                'categoria' => $categoria,
                'status' => 'success',
                'code' => 200,
            );
        } else {

            $data = array(
                'message' => 'Algo salio mal.. Porfavor intentelo nuevamente!',
                'status' => 'error',
                'code' => 400
            );

            //echo 'No Autenticado store -> Index de InstaladorController'; die();
        }

        return response()->json($data, 200);
    }

    //EDITAR // ACTUALIZAR CATEGORIA

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
                'categoria' => 'required|min:3',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            $categoria = Categoria::where('id', $id)->update($params_array);


            //devuelve el objeto data
            $data = array(
                'categoria' => $categoria,
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
        $categoria = Categoria::find($id);
        return response()->json(
            array(
                'categoria' => $categoria,
                'status' => 'success'
            ),
            200
        );
    }

    //DESTROY // ELIMINAR CATEGORIA

    public function destroy(Request $request, $id)
    {
        //Autorizacion
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            //Comprobar que existe el registro 
            // METODO FIND 
            $categoria = Categoria::find($id);

            //Borrarlo
            $categoria->delete();

            //Devolverlo
            $data = array(
                'message' =>
                $categoria,
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
