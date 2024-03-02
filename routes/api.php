<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\Auth\AdminAuthentication;
use App\Http\Controllers\Api\Auth\SellerAuthentication;
use App\Http\Controllers\Api\Auth\UserAuthentication;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

///////////////////////////// Admin Authentication //////////////////////////////
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthentication::class, 'login']);
    Route::post('register', [AdminAuthentication::class, 'register']);
    Route::get('logout', [AdminAuthentication::class, 'logout'])->middleware('auth:admin');
});

///////////////////////////// User Authentication //////////////////////////////
Route::prefix('user')->group(function () {
    Route::get('login', [UserAuthentication::class, 'login']);
    Route::post('register', [UserAuthentication::class, 'register']);
    Route::get('logout', [UserAuthentication::class, 'logout'])->middleware('auth:sanctum');
});

///////////////////////////// Seller Authentication //////////////////////////////
Route::prefix('seller')->group(function () {
    Route::get('login', [SellerAuthentication::class, 'login']);
    Route::post('register', [SellerAuthentication::class, 'register']);
    Route::get('logout', [SellerAuthentication::class, 'logout'])->middleware('auth:seller');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
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
    Route::get('get_orders/', [OrderController::class, 'index']);
    Route::get('add_items_to_order/{order}', [OrderController::class, 'addItemsToOrder']);
    Route::get('show_recipt/{order}', [OrderController::class, 'showReceipt']);
});
Route::middleware('check.super.admin')->group(function () {
    Route::get('order/admin/get_orders/', [OrderController::class, 'get_all_orders']);
});
