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
    Route::get('/guest/{order}/status', 'getOrderStatusGuest')->whereNumber('order');/*Não esta a passar, nao sei porque*/  // Requests for the kitchen
    Route::get('/board',                'getBoardItems');/*POR FAZER*/
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
        Route::get('/me',                       'customerInfo');/*Erro nao sei porque*/
        Route::get('/{customer}',               'show')->whereNumber('customer');/*Feito*/
        Route::get('/{customer}/order/{order}', 'orderDetails')->whereNumber('customer');/*Erro nao sei porque*/
        Route::get('/{customer}/orders',        'customerOrders')->whereNumber('customer');/*Feito*/
    });
    //--END CUSTOMER

    //--EMPLOYEE
    Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
        // Restaurant / Manager routes
        Route::get('/',                 'index');/*Feito*/
        Route::post('/',                'create');/*Feito*/
        Route::get('/{employee}',       'show')->whereNumber('employee');/*Erro nao sei porque*/
        Route::put('/{employee}',       'update')->whereNumber('employee');/*Por dar check*/
        Route::delete('/{employee}',    'delete')->whereNumber('employee');/*Por dar check*/
    });
    //--END EMPLOYEE

    //--PRODUCTS
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        // Only a manager can use this ones
        Route::post('/',                    'store');/*Feito*/
        Route::put('/{product}',            'update')->whereNumber('product');/*Erro por causa da func getTopItems*/
        Route::post('/{product}/photos',   'updatePhoto')->whereNumber('product');
        Route::delete('/{product}',         'destroy')->whereNumber('product');
        // TODO -> talvez para estatisticas?
        Route::get('/top-items',        'getTopItems');
        Route::get('/{product}/orders', 'getOrdersOfProduct')->whereNumber('product');
    });
    //--END PRODUCTS

    //--ORDERS
    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::get('/',                 'index');
        Route::get('/{order}',          'show')->whereNumber('order');
        Route::post('/payment',         'payment');
        Route::post('/{order}/refund',  'refund')->whereNumber('order');
        Route::put('/{order}',          'update')->whereNumber('order');
        Route::delete('/{order}',       'destroy')->whereNumber('order');

        // Requests for the kitchen
        Route::get('/active',                       'getActiveOrders');
        Route::get('/{order}/status',               'getOrderStatus')->whereNumber('order');
        Route::post('/{order}/status',              'setOrderStatus')->whereNumber('order');
    });
    //--END ORDERS
});
