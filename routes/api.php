<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix("/order/{order}")->group(function () {
    Route::post("/product", [OrderProductController::class, 'store']);
    Route::get("/products", [OrderProductController::class, 'index']);
    Route::delete("product/{product}", [OrderProductController::class, 'destroy']);
    Route::get("product/{product}", [OrderProductController::class, 'show']);
    Route::put("/product/{product}", [OrderProductController::class, 'update']);
});

Route::post("/order", [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/order/{id}', [OrderController::class, 'show']);
Route::put('/order/{id}', [OrderController::class, 'update']);
Route::delete('/order/{id}', [OrderController::class, 'destroy']);

Route::post('/product', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::put('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
Route::post('/category', [CategoryController::class, 'store']);
