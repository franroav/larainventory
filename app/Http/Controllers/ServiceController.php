<?php

/**
 * 
 * @author Francisco Roa <franroav@webkonce.cl>
 * 
 * 
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;


class ServiceController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client = new Client;
    }

    //PRUEBA DE CONEXION A UN SERVICIO REST 
    public function index(Request $request)
    {

        $cliente = $this->client;
        try {
            $res = $cliente->request('GET', env('SERVICE_URL') . '/users', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (ClientException $e) { // Errores 4xx
            \Log::info(Psr7\str($e->getRequest()));
            \Log::info(Psr7\str($e->getResponse()));
            if ($e->getResponse()->getStatusCode() == 422) {
                return response()->json(json_decode($e->getResponse()->getBody()), 422);
            } else {
                return response()->json("Error 4xx no 422, ver Log", 400);
            }
        } catch (RequestException $e) { // Errores 5xx
            \Log::info(Psr7\str($e->getRequest()));
            if ($e->hasResponse()) {
                \Log::info(Psr7\str($e->getResponse()));
                return response()->json('Error 5xx, ver Log', 500);
            }
        }
        return response()->json(array(
            'servicio' => json_decode($res->getBody()),
            'status' => 'success'
        ), 200);
        //return response()->json(json_decode($res->getBody()));


    }
}
