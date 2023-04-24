<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register/user', [UserController::class, 'register']);

Route::apiResource('products', ProductController::class);

Route::post('products/update/{id}', [ProductController::class, 'update']);

Route::post('create/cart', [CartController::class, 'createCart']);

Route::post('create/cart/product', [CartController::class, 'StoreCartProducts']);

Route::put('update/cart/product/{cart_id}', [CartController::class, 'updateCartProduct']);

Route::delete('delete/cart/product/{product_id}', [CartController::class, 'deleteCartProduct']);

Route::delete('delete/cart/{cart_id}', [CartController::class, 'deleteCart']);

Route::post('checkout', [CartController::class, 'checkout']);
