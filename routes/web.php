<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Routes for resource gateway
 */
$router->get('gateway', 'GatewaysController@all');
$router->get('gateway/{id}', 'GatewaysController@get');
$router->post('gateway', 'GatewaysController@add');
$router->put('gateway/{id}', 'GatewaysController@put');
$router->delete('gateway/{id}', 'GatewaysController@remove');

$router->get('/test/{datos}', function($datos){
    return "Mensaje: ". $datos;
});


/**
 * Routes for resource nodo
 */
$router->get('nodo', 'NodosController@all');
$router->get('nodo/{id}', 'NodosController@get');
$router->post('nodo', 'NodosController@add');
$router->put('nodo/{id}', 'NodosController@put');
$router->delete('nodo/{id}', 'NodosController@remove');