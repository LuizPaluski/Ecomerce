<?php

use App\Http\Api\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressUser;
//Register e login
Route::post('/login',  [AuthController::class, 'login']);
Route::post('/register',  [AuthController::class, 'register']);
Route::get('/verify-token',  [AuthController::class, 'verifyToken']);

//Precisa estar autenticado para pode atualizar o token
Route::middleware('auth:sanctum')->post('/renew-token',  [AuthController::class, 'renewToken']);

Route::middleware('auth:sanctum')->group(function ()  {
    //Users
    Route::get('/user/me', [Usercontroller::class, 'index']);
    Route::put('/user/me', [UserController::class, 'update']);
    Route::delete('/user/me', [AuthController::class, 'delete']);
    Route::post('/user/create-moderator', function () {});
    Route::put('/user/imagem', function () {});

    //address
    Route::get('/address/', [AddressUser::class, 'index']);
    Route::post('/address/', [AddressUser::class, 'store']);;
    Route::put('/address/{address_id}', [AddressUser::class, 'update']);;
    Route::get('/address/{address_id}', [AddressUser::class, 'show']);
    Route::delete('/address/{address_id}', [AddressUser::class, 'destroy']);
    //categories
    Route::get('/categories', function () {});
    Route::post('/categories', function (){});
    Route::put('/categories/{category_id}', function () {});
    Route::get('/categories/{category_id}', function () {});
    Route::delete('/categories/{category_id}', function () {});

    //Tags
    Route::get('/tags', function () {});
    Route::post('/tags', function () {});
    Route::put('/tags/{tag_id}', function () {});
    Route::get('/tags/{tag_id}', function () {});
    Route::delete('/tags/{tag_id}', function () {});
    Route::post('/tags/{tag_od}/products/{product_id}', function () {});
    Route::delete('/tags/{tag_od}/products/{product_id}', function () {});

    //Products
    Route::get('/products', function () {});
    Route::post('/products', function () {});
    Route::get('/products/user/{user_id}', function () {});
    Route::get('/products/category/{category_id}', function () {});
    Route::get('/products/{product_id}', function () {});
    Route::put('/products/{product_id}', function () {});
    Route::delete('/products/{product_id}', function () {});
    Route::put('/products/{product_id}/stock', function () {});
    Route::put('/products/{product_id}/images', function () {});

    //Discounts
    Route::get('/discounts', function () {});
    Route::post('/discounts', function () {});
    Route::get('/discounts/{discount_id}', function () {});
    Route::put('/discounts/{discount_id}', function () {});
    Route::delete('/discounts/{discount_id}', function () {});

    //Coupons
    Route::get('/coupons/', function () {});
    Route::post('/coupons/', function () {});
    Route::get('/coupons/{coupon_id}', function () {});
    Route::put('/coupons/{coupon_id}', function () {});
    Route::delete('/coupons/{coupon_id}', function () {});

    //Cart
    Route::get('/cart/', function () {});
    Route::post('/cart/', function () {});
    Route::get('/cart/items', function () {});
    Route::put('/cart/items', function () {});
    Route::post('/cart/items', function () {});
    Route::delete('/cart/items', function () {});
    Route::delete('/cart/clear', function () {});

    //Orders
    Route::get('/orders/all', function () {});
    Route::get('/orders/', function () {});
    Route::post('/orders/', function () {});
    Route::get('/orders/{order_id}', function () {});
    Route::put('/orders/{order_id}', function () {});
    Route::delete('/orders/{order_id}', function () {});
    Route::get('/orders/all/{admin_id}', function () {});


});
