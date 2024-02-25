<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AdminAuthentication;
use App\Http\Controllers\Api\Auth\SellerAuthentication;
use App\Http\Controllers\Api\Auth\SuperAdminAuthentication;
use App\Http\Controllers\Api\Auth\UserAuthentication;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\TestController;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

///////////////////////////// Admin Authentication //////////////////////////////
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthentication::class, 'login']);
    Route::post('register', [AdminAuthentication::class, 'register']);
});

///////////////////////////// User Authentication //////////////////////////////
Route::prefix('user')->group(function () {
    Route::get('login', [UserAuthentication::class, 'login']);
    Route::post('register', [UserAuthentication::class, 'register']);
});

///////////////////////////// Seller Authentication //////////////////////////////
Route::prefix('seller')->group(function () {
    Route::get('login', [SellerAuthentication::class, 'login']);
    Route::post('register', [SellerAuthentication::class, 'register']);
});

Route::prefix('admin_crud')->middleware('auth:admin')->group(function () {
    Route::post('store', [AdminController::class, 'store']);
    Route::get('show/{admin}', [AdminController::class, 'show']);
    Route::put('update/{admin}', [AdminController::class, 'update']);
    Route::get('get_all', [AdminController::class, 'index']);
    Route::delete('delete/{admin}', [AdminController::class, 'destroy']);
});
Route::prefix('product')->middleware('auth:seller')->group(function () {
    Route::post('store', [ProductController::class, 'store']);
    Route::get('show/{product}', [ProductController::class, 'show']);
    Route::put('update/{product}', [ProductController::class, 'update']);
    Route::get('get_all', [ProductController::class, 'index']);
    Route::delete('delete/{product}', [ProductController::class, 'destroy']);
});
Route::prefix('category')->middleware('auth:admin')->group(function () {
    Route::post('store', [CategoryController::class, 'store']);
    Route::get('show/{category}', [CategoryController::class, 'show']);
    Route::put('update/{category}', [CategoryController::class, 'update']);
    Route::get('get_all', [CategoryController::class, 'index']);
    Route::delete('delete/{category}', [CategoryController::class, 'destroy']);
});

Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::post('store/', [OrderController::class, 'store']);
    Route::put('update/{order}', [OrderController::class, 'update']);
    Route::get('show/{order}', [OrderController::class, 'show']);
    Route::delete('delete/{order}', [OrderController::class, 'destroy']);
    Route::get('get_all/', [OrderController::class, 'index']);
    Route::get('show_recipt/{order}', [OrderController::class, 'showReceipt']);
});
