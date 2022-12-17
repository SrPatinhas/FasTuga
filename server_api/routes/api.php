<?php

use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\OrderController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login',        'login');
    Route::post('register',     'register');
});

Route::controller(OrderController::class)->prefix('orders')->group(function () {
    Route::post('/guest/payment',       'paymentGuest');
    Route::get('/guest/{order}',        'showGuest')->whereNumber('order');
    Route::get('/guest/{order}/status', 'getOrderStatusGuest')->whereNumber('order');// Requests for the kitchen
    Route::get('/board',                'getBoardItems');
});

// Leave this 3 requests public so anyone can get them
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/',             'index');
    Route::get('/trending',     'trending');
    Route::get('/{product}',    'show')->whereNumber('product');
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    //--USER
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/me',                  'userInfo');
        Route::get('/{user}',              'show')->middleware('can:view,user')->whereNumber('user'); // <--Para quem esta logado
        Route::put('/{user}',              'update')->middleware('can:update,user')->whereNumber('user');
        Route::patch('/{user}/password',   'update_password')->middleware('can:updatePassword,user')->whereNumber('user');
        Route::post('/photo',              'uploadPhoto');

        // Only Manager
        Route::post('/{user}/block',       'block')->whereNumber('user');
        Route::post('/{user}/unblock',     'unblock')->whereNumber('user');
    });
    //--END USER

    //--CUSTOMER
    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('/',                         'index');
        Route::get('/{customer}',               'show')->whereNumber('customer');
        Route::get('/{customer}/order/{order}', 'order')->whereNumber('customer');
        Route::get('/{customer}/orders',        'orders')->whereNumber('customer');
    });
    //--END CUSTOMER

    //--EMPLOYEE
    Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
        // Restaurant / Manager routes
        Route::get('/',                 'index');
        Route::post('/',                'create');
        Route::get('/{employee}',       'show')->whereNumber('employee');
        Route::put('/{employee}',       'update')->whereNumber('employee');
        Route::delete('/{employee}',    'delete')->whereNumber('employee');
    });
    //--END EMPLOYEE

    //--PRODUCTS
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        // Only a manager can use this ones
        Route::post('/',                    'store');
        Route::put('/{product}',            'update')->whereNumber('product');
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
