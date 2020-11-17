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
use App\Ventas;
// helper 
use App\Helpers\JwtAuth;

class VentasController extends Controller
{
    //LISTADO GLOBAL DE TODOS LAS VENTAS
    public function index(Request $request)
    {
        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            //TODAS LAS VENTAS
            $ventas = Ventas::all();
            return response()->json(array(
                'ventas' => $ventas,
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

    //CREAR VENTA // GUARDAR 
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
                'codigo' => 'required|min:3',
                'productos' => 'required',
                'metodo_pago' => 'required',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            // Guardar Venta
            $ventas = new Ventas();
            $ventas->codigo = $params->codigo;
            $ventas->id_cliente = $params->id_categoria;
            $ventas->id_pedido = $params->id_proveedor;
            $ventas->id_pedido = $params->id_vendedor;
            $ventas->productos = $params->productos;
            $ventas->impuesto = $params->impuesto;
            $ventas->neto = $params->neto;
            $ventas->total = $params->total;
            $ventas->metodo_pago = $params->metodo_pago;
            $ventas->fecha = $params->precio_venta;
            $ventas->descuento = $params->descuento;
            $ventas->estado = $params->unidad_medida;
            $ventas->fecha = $params->fecha;
            $ventas->save();

            //si la autenticación es exitosa devuelve el objeto data con codigo 200

            $data = array(
                'producto' => $ventas,
                'status' => 'success',
                'code' => 200,
            );
        } else {

            //Devolver un Error 300

            $data = array(
                'message' => 'Algo salio mal.. Porfavor intentelo nuevamente!',
                'status' => 'error',
                'code' => 300
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

            //Actualizar el coche 

            //Recoger parametros por POST
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

            //Validacion de datos 
            //validación , la funcion validate necesita un array , no un json.
            $validate = \Validator::make($params_array, [
                'codigo' => 'required|min:3',
                'productos' => 'required',
                'metodo_pago' => 'required',
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            //buscar el registro
            $ventas = Ventas::where('id', $id)->update($params_array);

            //si la autenticación es exitosa devuelve el objeto data

            $data = array(
                'producto' => $ventas,
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

            //echo 'No Autenticado store -> Index de InstaladorController';
            die();
        }

        return response()->json($data, 200);
    }

    //SHOW

    public function show($id)
    {
        // load user carga el usuario contendio en la consulra.
        $ventas = Ventas::find($id);
        return response()->json(
            array(
                'producto' => $ventas,
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
            $ventas = Ventas::find($id);

            //Borrarlo
            $ventas->delete();

            //Devolverlo
            $data = array(
                'message' => $ventas,
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
