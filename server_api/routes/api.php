<?php

use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderGuestController;


Route::controller(AuthController::class)->group(function () {
    Route::post('login',        'login'); /*Feito*/
    Route::post('register',     'register');
});

Route::controller(OrderGuestController::class)->prefix('orders')->group(function () {
    Route::post('/guest/payment',       'paymentGuest');/*POR FAZER*/
    Route::get('/guest/{order}',        'showGuest')->whereNumber('order'); /*Feito*/
    Route::get('/guest/{order}/status', 'getOrderStatusGuest')->whereNumber('order');/*Feito*/  // Requests for the kitchen
    Route::get('/board',                'getBoardItems');/*Feito*/
});

// Leave this 3 requests public so anyone can get them
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/',             'index'); /*Feito*/
    Route::get('/trending',     'trending');/*Feito*/
    Route::get('/{product}',    'show')->whereNumber('product');/*Feito*/
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    //--USER
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/me',                  'userInfo');/*Feito*/
        Route::get('/{user}',              'show')->middleware('can:view,user')->whereNumber('user');/*Feito*/ // <--Para quem esta logado
        Route::put('/{user}',              'update')->middleware('can:update,user')->whereNumber('user');/*Feito*/
        Route::patch('/{user}/password',   'update_password')->middleware('can:updatePassword,user')->whereNumber('user');/*Feito*/
        Route::post('/photo',              'uploadPhoto');/*Feito*/

        // Only Manager
        Route::post('/{user}/block',       'block')->whereNumber('user');/*Feito*/
        Route::post('/{user}/unblock',     'unblock')->whereNumber('user');/*Feito*/
    });
    //--END USER

    //--CUSTOMER
    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('/',                         'index'); /*Feito*/
        Route::get('/me',                       'customerInfo');/*Feito*/
        Route::get('/{customer}',               'show')->whereNumber('customer');/*Feito*/
        Route::get('/{customer}/order/{order}', 'orderDetails')->whereNumber('customer');/*Feito*/
        Route::get('/{customer}/orders',        'customerOrders')->whereNumber('customer');/*Feito*/
        Route::get('/top-products',             'topProducts');/*Feito*/
        Route::get('/last-orders',              'lastOrders');/*Feito*/
    });
    //--END CUSTOMER

    //--EMPLOYEE
    Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
        // Restaurant / Manager routes
        Route::get('/',                 'index');/*Feito*/
        Route::post('/',                'create');/*Feito*/
        Route::get('/{user}',           'show')->whereNumber('user');/*Feito*/
        Route::put('/{user}',           'update')->whereNumber('user');/*Feito*/
        Route::delete('/{user}',        'delete')->whereNumber('user');/*Feito*/
    });
    //--END EMPLOYEE

    //--PRODUCTS
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        // Only a manager can use this ones
        Route::post('/',                    'store');/*Feito*/
        Route::put('/{product}',            'update')->whereNumber('product');/*Erro por causa da func getTopItems*/
        Route::post('/{product}/photos',   'updatePhoto')->whereNumber('product');/*Erro */
        Route::delete('/{product}',         'destroy')->whereNumber('product');/*Erro database */
        // TODO -> talvez para estatisticas?
        Route::get('/top-items',        'getTopItems');/*Erro */
        Route::get('/{product}/orders', 'getOrdersOfProduct')->whereNumber('product');
    });
    //--END PRODUCTS

    //--ORDERS
    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::get('/',                 'index');   /*Feito*/
        Route::get('/{order}',          'show')->whereNumber('order'); /*Feito*/
        Route::post('/payment',         'payment');  /*Por fazer*/
        Route::post('/{order}/refund',  'refund')->whereNumber('order');/*Por fazer*/
        Route::put('/{order}',          'update')->whereNumber('order');/*Erro */
        Route::delete('/{order}',       'destroy')->whereNumber('order');/*Erro database */

        // Requests for the kitchen
        Route::get('/active',                       'getActiveOrders');/*Feito*/
        Route::get('/{order}/status',               'getOrderStatus')->whereNumber('order');/*Erro */
        Route::post('/{order}/status',              'setOrderStatus')->whereNumber('order');
    });
    //--END ORDERS
});
