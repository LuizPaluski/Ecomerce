<?php

use App\Http\Api\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\OrdersController;


//Register e login
Route::post('/login',  [AuthController::class, 'login']);
Route::post('/register',  [AuthController::class, 'register']);
Route::get('/verify-token',  [AuthController::class, 'verifyToken']);

//Precisa estar autenticado para pode atualizar o token
Route::middleware('auth:sanctum')->post('/renew-token',  [AuthController::class, 'renewToken']);

// Rotas publicas
Route::get('/products', [ProductsController::class, 'showAll']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/categories', [CategoriesController::class, 'show']);


Route::middleware('auth:sanctum')->group(function ()  {
    //Users
    Route::get('/user/me', [UserController::class, 'index']);
    Route::put('/user/me', [UserController::class, 'update']);
    Route::delete('/user/me', [AuthController::class, 'delete']);
    Route::post('/user/imagen', [UserController::class, 'uploadImage']);
    Route::post('/user/create-moderator', [UserController::class, 'createModerator'])->middleware('admin');

    //address
    Route::apiResource('addresses', AddressController::class);


    //categories
    Route::middleware('admin')->group(function () {
        Route::post('/categories', [CategoriesController::class, 'store']);
        Route::put('/categories/{category_id}', [CategoriesController::class, 'update']);
        Route::delete('/categories/{category_id}', [CategoriesController::class, 'destroy']);
    });

    //ProductsController
    Route::middleware('moderator')->group(function () {
        Route::post('/products', [ProductsController::class, 'store']);
        Route::put('/products/{product_id}', [ProductsController::class, 'update']);
        Route::delete('/products/{product_id}', [ProductsController::class, 'destroy']);
        Route::post('/products/{product_id}/images', [ProductsController::class, 'image']);
    });

    //DiscountsController
    Route::middleware('admin')->group(function () {
        Route::apiResource('discounts', DiscountsController::class);
    });

    //CouponsController
    Route::middleware('admin')->group(function () {
        Route::apiResource('coupons', CouponsController::class);
    });

    //Cart
    Route::get('/cart/', [CartsController::class, 'index']);
    Route::post('/cart/', [CartsController::class, 'store']);
    Route::delete('/cart/clear', [CartsController::class, 'destroy']);

    //OrdersController
    Route::get('/orders/', [OrdersController::class, 'index']);
    Route::post('/orders/', [OrdersController::class, 'store']);
    Route::get('/orders/{order}', [OrdersController::class, 'show']);
    Route::put('/orders/{order}', [OrdersController::class, 'update'])->middleware('moderator');
    Route::delete('/orders/{order}', [OrdersController::class, 'destroy']);

});
