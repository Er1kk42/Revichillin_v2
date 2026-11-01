<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::view('/about', 'about')->name('about');
Route::view('/contacts', 'contacts')->name('contacts');
Route::view('/gallery', 'gallery')->name('gallery');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('productShow');

Route::view('/register', 'register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('registerSubmit');

Route::view('/login', 'login')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('loginSubmit');

Route::middleware('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'showProfile'])->name('user');
    Route::post('/user', [AuthController::class, 'updateProfile'])->name('userUpdate');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviewStore');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviewUpdate');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviewDestroy');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/{item}', [CartController::class, 'addToCart'])->name('cartAdd');
    Route::post('/cart/{item}/remove', [CartController::class, 'removeFromCart'])->name('cartRemove');
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cartDestroy');

    Route::post('/orders', [OrderController::class, 'store'])->name('orderStore');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
