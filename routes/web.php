<?php
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');
Route::view('/user', 'user')->middleware('auth')->name('user');
Route::post('/user', [AuthController::class, 'updateProfile'])->middleware('auth')->name('user.update');
Route::get('/test', function () {
    return 'ahoj';
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/cart', [CartController::class, 'index'])->middleware('auth')->name('cart');
// TODO: AJAX routy košíka (všetky s middleware('auth')):
//       Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
//       Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
//       Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/contacts', function () {
    return view('contacts');
});
Route::get('/gallery', function () {
    return view('gallery');
});
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');



