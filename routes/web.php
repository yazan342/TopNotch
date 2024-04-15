<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::delete('/product/{id}', [DashboardController::class, 'deleteProduct'])->name('product.delete');
Route::delete('/user/{id}', [DashboardController::class, 'deleteUser'])->name('user.delete');
Route::get('/user/{id}', [DashboardController::class, 'showUser'])->name('user.profile');
Route::post('/product/{id}/accept',  [DashboardController::class, 'acceptProduct'])->name('product.accept');
Route::post('/product/{id}/reject',  [DashboardController::class, 'rejectProduct'])->name('product.reject');
Route::get('/product/{id}', [DashboardController::class, 'show'])->name('product.show');
