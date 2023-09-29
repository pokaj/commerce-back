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

$router->group(['prefix' => 'api/v1'], function () use ($router) {


//    Auth
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('signup', 'AuthController@signUp');
        $router->post('login', 'AuthController@login');
    });


//    Product
    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->post('', 'ProductController@addProduct');
        $router->get('', 'ProductController@getProducts');
        $router->get('/{id}', 'ProductController@retrieveProduct');
    });


//    Cart
    $router->group(['prefix' => 'cart'], function () use ($router) {
        $router->post('', 'cartController@addProductToCart');
        $router->post('/checkout/{user_id}', 'cartController@checkout');
        $router->post('/remove', 'cartController@removeFromCart');
        $router->get('/{user_id}', 'cartController@fetchUserCartProducts');
    });

});
