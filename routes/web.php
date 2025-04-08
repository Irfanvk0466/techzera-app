<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductDetailController;

// Public Routes
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product}/{variant}', [ProductDetailController::class, 'show'])->name('product.details');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [PaymentController::class, 'store'])->name('checkout.store');
Route::get('/order/confirmation', [PaymentController::class, 'orderConfirmation'])->name('order.confirmation');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'verify'])->name('verify');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});
