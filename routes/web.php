<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['middleware' => 'checkapi'], function () use ($router) {
    $router->get('/test','UserController@test');
    $router->get('/users/{id}','UserController@get');
    $router->get('/users','UserController@index');
    $router->post('/users/register','UserController@create');
    $router->patch('/users','UserController@update');

});

