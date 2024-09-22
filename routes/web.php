<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
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

Route::view('/', 'home')->name('home');

Route::view('/listCategories', 'categories.list')->name('categories.list');
Route::view('/categories/create', 'categories.create')->name('categories.create');
Route::view('/categories/create/{id}', 'categories.create')->name('categories.edit');
Route::middleware(['validate.category'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});

Route::view('/products/create', 'products.create')->name('products.create');
Route::view('/products/create/{id}', 'products.create')->name('products.edit');
