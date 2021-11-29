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

$router->group(['prefix' => 'api'], function() use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('register', 'AuthController@register');

    $router->get('/todos', 'UserTodoController@index');
    $router->get('/todos/{id}', 'UserTodoController@show');
    $router->post('/todos', 'UserTodoController@store');
    $router->put('/todos/{id}', 'UserTodoController@update');
    $router->delete('/todos/{id}', 'UserTodoController@destroy');

    $router->get('/categories', 'UserCategoryController@index');
    $router->get('/categories/{id}', 'UserCategoryController@show');
    $router->post('/categories', 'UserCategoryController@store');
    $router->put('/categories/{id}', 'UserCategoryController@update');
    $router->delete('/categories/{id}', 'UserCategoryController@destroy');
});
