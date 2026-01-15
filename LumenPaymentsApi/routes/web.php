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

// Routes for payments
$router->post('/payments', 'PaymentController@store');
$router->get('/payments/{id}', 'PaymentController@show');
$router->get('/payments/order/{order_id}', 'PaymentController@getByOrder');
$router->post('/payments/{id}/refund', 'PaymentController@refund');
$router->get('/payments/user/{user_id}', 'PaymentController@getByUser');
