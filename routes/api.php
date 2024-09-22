<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['validate.register'])->post('/register', [AuthController::class, 'register']);
Route::middleware(['validate.login'])->post('/login', [AuthController::class, 'login']);
Route::middleware(['validate.userEdit'])->put('/userEdit/{id}', [AuthController::class, 'userEdit']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/imageSearch', [ProductController::class, 'imageSearch']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::middleware(['validate.product'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/search', [CategoryController::class, 'search']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::middleware(['validate.category'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
});
