<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Auth\UserAuthentication;
use App\Http\Controllers\Api\Auth\AdminAuthentication;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\SellerAuthentication;
use App\Http\Controllers\Api\Seller\SellerController;
use App\Http\Controllers\LogoutController;

///////////////////////////// Admin Authentication //////////////////////////////
Route::prefix('admins')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [AdminAuthentication::class, 'register'])->middleware('check.super.admin');
    Route::get('logout', [LogoutController::class, 'logout'])->middleware('auth:admin');
});

///////////////////////////// User Authentication //////////////////////////////
Route::prefix('users')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [UserAuthentication::class, 'register']);
    Route::get('logout', [LogoutController::class, 'logout'])->middleware('auth:user');
});

///////////////////////////// Seller Authentication //////////////////////////////
Route::prefix('sellers')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [SellerAuthentication::class, 'register']);
    Route::get('logout', [LogoutController::class, 'logout'])->middleware('auth:seller');
});

Route::post('admins', [AdminController::class, 'store']);
Route::get('admins/{admin}', [AdminController::class, 'show'])->middleware('auth:admin');
Route::put('admins/{admin}', [AdminController::class, 'update'])->middleware('auth:admin');
Route::get('admins', [AdminController::class, 'index'])->middleware('check.super.admin');
Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->middleware('check.super.admin');

////////////////// Seller CRUD routes ////////////////////
Route::post('sellers', [SellerController::class, 'store']);
Route::middleware('auth:seller')->group(function () {
    Route::get('sellers/{seller}', [SellerController::class, 'show']);
    Route::put('sellers/{seller}', [SellerController::class, 'update']);
    Route::get('sellers', [SellerController::class, 'index']);
});
Route::delete('sellers/{seller}', [SellerController::class, 'destroy'])->middleware('check.super.admin');

////////////////// User CRUD routes ////////////////////
Route::middleware('auth:admin')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});
Route::post('users', [UserController::class, 'store']);
Route::middleware('auth:user')->group(function () {
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
});
////////////////// Products CRUD routes ////////////////////
Route::post('products', [ProductController::class, 'store'])->middleware('auth:seller');
Route::get('products/{product}', [ProductController::class, 'show']); // any user even if guest
Route::put('products/{product}', [ProductController::class, 'update'])->middleware('auth:seller');
Route::get('products', [ProductController::class, 'index'])->middleware('auth:seller');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->middleware('auth:seller');

////////////////// Categories CRUD routes ////////////////////
Route::middleware('auth:admin')->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
});

////////////////// Orders CRUD routes ////////////////////
Route::middleware('auth:user')->group(function () {
    Route::post('orders', [OrderController::class, 'store']);
    Route::put('orders/{order}', [OrderController::class, 'update']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::delete('orders/{order}', [OrderController::class, 'destroy']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders/{order}/items', [OrderController::class, 'addItemsToOrder']);
    Route::get('orders/{order}/receipt', [OrderController::class, 'showReceipt']);
});
Route::middleware('check.super.admin')->group(function () {
    Route::get('admin/orders', [OrderController::class, 'allOrders']);
});
