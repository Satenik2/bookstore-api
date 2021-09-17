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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('book', 'BookController@index');
        $router->post('book', 'BookController@store');
        $router->put('book/{id}', 'BookController@update');
        $router->get('book/{id}', 'BookController@show');
        $router->delete('book/{id}', 'BookController@destroy');

        $router->get('order', 'OrderController@index');
        $router->post('order', 'OrderController@store');
        $router->put('order/{id}', 'OrderController@update');
        $router->get('order/{id}', 'OrderController@show');
        $router->delete('order/{id}', 'OrderController@destroy');
    });
});
