<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SortController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => ['auth:api']], function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::post('wishlist/add/{product}', [WishlistController::class, 'addToWishlist']);
    Route::delete('wishlist/remove/{product}', [WishlistController::class, 'removeFromWishlist']);
    Route::get('wishlist', [WishlistController::class, 'getUserWishlist']);
    Route::post('search', [SearchController::class, 'search']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::delete('/cart/remove/{product_id}', [CartController::class, 'removeProductFromCart']);
    Route::delete('/cart/delete/{product_id}', [CartController::class, 'deleteProductFromCart']);
    Route::get('/cart', [CartController::class, 'getUserCart']);
    Route::delete('/cart/empty', [CartController::class, 'emptyCart']);
    Route::post('/sort', [SortController::class, 'sortProducts']);
    Route::get('/order', [OrderController::class, 'createOrder']);
    Route::get('/order/get', [OrderController::class, 'showUserOrders']);
    Route::get('/user/products', [ProductController::class, 'getUserProducts']);
    Route::get('/user/info', [AuthController::class, 'getUserInfo']);
    Route::post('logout', [AuthController::class, 'logout']);
});
