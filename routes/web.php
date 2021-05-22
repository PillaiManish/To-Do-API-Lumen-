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

$router->post('login','AccountController@login');
$router->post('register','AccountController@register');
$router->post('register','AccountController@register');
$router->post('logout','AccountController@logout');

$router->group(['prefix' => 'todo'], function () use ($router) {
    $router->post('/','ToDoController@list');
    $router->post('add','ToDoController@add');
    $router->delete('delete','ToDoController@delete');
});


