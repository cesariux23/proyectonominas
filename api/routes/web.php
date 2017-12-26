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

//autenticacion
$router->post('auth/login', ['uses' => 'AuthController@postLogin']);

//catalogos
//$router->get('/catalogos','CatalogosController@index');
//empleados
$router->get('/empleado','EmpleadoController@index');
$router->get('/empleado/{id}','EmpleadoController@show');
$router->post('/empleado','EmpleadoController@store');
$router->patch('/empleado/{id}','EmpleadoController@update');

//adscripciones
$router->post('/adscripcion','AdscripcionController@store');
$router->patch('/adscripcion/{id}','AdscripcionController@update');

// movimientos
$router->post('/empleado/{id}/movimiento','MovimientoController@store');

// nominas
$router->get('/nomina','NominaController@index');
$router->get('/nomina/{id}','NominaController@show');
$router->post('/nomina','NominaController@store');

$router->group(['middleware' => 'auth:api'], function($router)
{
    $router->get('/catalogos','CatalogosController@index');
});
