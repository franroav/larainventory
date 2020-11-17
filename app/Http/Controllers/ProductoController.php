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
use App\Producto;
use App\Helpers\JwtAuth;

class ProductoController extends Controller
{

    //LISTADO GLOBAL DE TODOS LOS PRODUCTOS
    public function index(Request $request)
    {

        $hash = $request->header('Authorization', null);
        // intancio la clase jwtAuth();
        $jwtAuth = new jwtAuth();
        //llamo al metodo checkToken 
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {

            $productos = Producto::all();
            return response()->json(array(
                'productos' => $productos,
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

        //var_dump($checkToken); die();

        /* try {

            if($stmt->execute()){

                return $stmt->fetch();

            };

        } catch (Exception $e) {

            echo 'Excepción capturada: ',  $e->getMessage(), "\n";

        }*/

        if ($checkToken) {
            //Recoger los datos por Post
            $json = $request->input('json', null);
            $params = json_decode($json);

            // convertir objeto json en un array pasandole el paramento true.
            $params_array = json_decode($json, true);

            //Conseguir el usuario Identificado    		
            $user = $jwtAuth->checkToken($hash, true);

            $validate = \Validator::make($params_array, [
                'codigo' => 'required|min:3',
                'descripcion' => 'required',
                'stock' => 'required',
                'precio_venta' => 'required'
            ]);



            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            $producto = new Producto();
            $producto->id_categoria = $params->id_categoria;
            $producto->id_proveedor = $params->id_proveedor;
            $producto->codigo = $params->codigo;
            $producto->descripcion = $params->descripcion;
            $producto->imagen = $params->imagen;
            $producto->stock = $params->stock;
            $producto->precio_compra = $params->precio_compra;
            $producto->precio_venta = $params->precio_venta;
            $producto->ventas = $params->ventas;
            $producto->descuento = $params->descuento;
            $producto->unidad_medida = $params->unidad_medida;
            $producto->fecha = $params->fecha;
            $producto->save();

            //devuelve el objeto data

            $data = array(
                'producto' => $producto,
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

    //EDITAR // ACTUALIZAR PRODUCTO 

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
                'codigo' => 'required|min:3',
                'descripcion' => 'required',
                'stock' => 'required',
                'precio_venta' => 'required'
            ]);

            //Capturar errores

            if ($validate->fails()) {

                return response()->json($validate->errors(), 400);
            }

            //Actualizar el Registro
            $producto = Producto::where('id', $id)->update($params_array);

            //devuelve el objeto data

            $data = array(
                'producto' => $producto,
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
        // load user carga el usuario contendio en la consulra.
        $producto = Producto::find($id)->load('user');
        return response()->json(
            array(
                'producto' => $producto,
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
            $producto = Producto::find($id);

            //Borrarlo
            $producto->delete();

            //Devolverlo
            $data = array(
                'message' => $producto,
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
