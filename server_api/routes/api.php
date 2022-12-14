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
    Route::post('register',     'register');/*Feito*/
});

Route::controller(OrderGuestController::class)->prefix('orders')->group(function () {
    Route::post('/guest/payment',       'paymentGuest');/*Feito*/
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
        Route::patch('/{user}/block',       'block')->whereNumber('user');/*Feito*/
        Route::patch('/{user}/unblock',     'unblock')->whereNumber('user');/*Feito*/
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
        Route::put('/{user}',           'update')->whereNumber('user');/*Feito TEMOS DE PASSAR O "type":"EM",*/
        Route::delete('/{user}',        'destroy')->whereNumber('user');/*Feito*/

        Route::get('/sidebar',          'sidebarCounts');/*Feito*/
        Route::get('/statistic',        'statistic');/*Feito*/
    });
    //--END EMPLOYEE

    //--PRODUCTS
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        // Only a manager can use this ones
        Route::post('/',                    'store');/*Feito*/
        Route::get('/list',                 'list')->withTrashed();/*Feito*/
        Route::put('/{product}',            'update')->whereNumber('product')->withTrashed();/*Feito*/
        Route::post('/{product}',            'update')->whereNumber('product');/*Feito*/
        Route::post('/{product}/photos',    'updatePhoto')->whereNumber('product');/*Erro */
        Route::delete('/{product}',         'destroy')->whereNumber('product');/*Feito*/
        // TODO -> talvez para estatisticas?
        Route::get('/top-items',        'getTopItems');/*Feito*/
        Route::get('/{product}/orders', 'getOrdersOfProduct')->whereNumber('product');/*Feito*/
    });
    //--END PRODUCTS

    //--ORDERS
    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::get('/',                 'index');   /*Feito*/
        Route::get('/{order}',          'show')->whereNumber('order'); /*Feito*/
        Route::post('/payment',         'payment');  /*Feito*/
        Route::put('/{order}',          'update')->whereNumber('order');/*Erro */
        Route::delete('/{order}',       'destroy')->whereNumber('order');/*Feito */

        // Requests for the kitchen
        Route::get('/restaurant',                   'getActiveOrders');/*Feito*/
        Route::get('/{order}/status',               'getOrderStatus')->whereNumber('order');/*Erro */
        Route::patch('/{order}/status',             'setOrderStatus')->whereNumber('order');
        Route::patch('/{orderItem}/item/status',    'setOrderItemStatus')->whereNumber('orderItem');
    });
    //--END ORDERS
});
