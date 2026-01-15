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

    /**
     * Authors routes
     */
    $router->get('/authors', 'AuthorController@index');
    $router->post('/authors', 'AuthorController@store');
    $router->get('/authors/{author}', 'AuthorController@show');
    $router->put('/authors/{author}', 'AuthorController@update');
    $router->patch('/authors/{author}', 'AuthorController@update');
    $router->delete('/authors/{author}', 'AuthorController@destroy');


$router->group(['prefix' => 'books'], function () use ($router) {
    $router->get('/', 'BookController@index');
    $router->post('/', 'BookController@store');
    $router->get('/{book}', 'BookController@show');
    $router->put('/{book}', 'BookController@update');
    $router->patch('/{book}', 'BookController@update');
    $router->delete('/{book}', 'BookController@destroy');
});

$router->get('/test', function () {
    return 'Gateway routes are working!';
});

$router->group(['prefix' => 'payments'], function () use ($router) {
    $router->post('/', 'PaymentController@processPayment');
    $router->get('/{id}', 'PaymentController@getPayment');
    $router->get('/order/{order_id}', 'PaymentController@getPaymentsByOrder');
    $router->post('/{id}/refund', 'PaymentController@processRefund');
    $router->get('/user/{user_id}', 'PaymentController@getPaymentsByUser');
});

