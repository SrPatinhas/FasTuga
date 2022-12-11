<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\OrderController;

Route::post('login', [AuthController::class, 'login']);
Route::post('login-guest', [AuthController::class, 'loginAsGuest']);
Route::post('register', [AuthController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users/me', [UserController::class, 'show_me']);

    Route::controller(UserController::class)->group(function () {
        Route::get('users',                     'index');
        Route::get('users/{user}',              'show')->middleware('can:view,user'); // <--Para quem esta logado
        Route::put('users/{user}',              'update')->middleware('can:update,user');
        Route::patch('users/{user}/password',   'update_password')->middleware('can:updatePassword,user');
    });

    //--PRODUCTS
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/',             'index');
        Route::get('/{product}',    'show');
        Route::post('/',            'store');
        Route::put('/{product}',    'update');
        Route::delete('/{product}', 'destroy');
    });
    //--END PRODUCTS


    //--ORDERS
    Route::controller(OrderController::class)->prefix('products')->group(function () {
        Route::get('products/{product}/orders', 'getOrdersOfProduct');
        Route::get('orders', 'index');
        Route::get('orders/{order}', 'show');
        Route::post('orders', 'store');
        Route::put('orders/{order}', 'update');
        Route::delete('orders/{order}', 'destroy');
    });
    //--END ORDERS




    /*
    Route::get('users/{user}/tasks', [TaskController::class, 'getTasksOfUser']);
    Route::get('tasks/{task}', [TaskController::class, 'show']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::patch('tasks/{task}/completed', [TaskController::class, 'update_completed']);

    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{project}', [ProjectController::class, 'show']);
    Route::get('projects/{project}/tasks', [ProjectController::class, 'showWithTasks']);
    Route::post('projects', [ProjectController::class, 'store']);
    Route::delete('projects/{project}', [ProjectController::class, 'destroy']);
    Route::put('projects/{project}', [ProjectController::class, 'update']);
    Route::get('users/{user}/projects', [ProjectController::class, 'getProjectsOfUser']);
    Route::get('users/{user}/projects/inprogress', [ProjectController::class, 'getProjectsInProgressOfUser']);
 */

});

