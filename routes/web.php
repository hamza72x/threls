<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'getHome'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

# products
Route::group(['prefix' => 'products', 'middleware' => 'auth'], function () {
    // seller only
    Route::middleware('is_seller')->group(function () {
        Route::post('/import', [ProductController::class, 'import'])->name('products.import');
    });
});

# cart
Route::group(['prefix' => 'cart', 'middleware' => 'auth'], function () {
    // buyer only
    Route::middleware('is_buyer')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        // default cart
        Route::post('/{product_id}/add', [CartController::class, 'addToCart'])->name('cart.add-item');
        // default cart
        Route::post('/{product_id}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove-item');
    });
});

# orders
Route::group(['prefix' => 'orders', 'middleware' => 'auth'], function () {
    // buyer only
    Route::middleware('is_buyer')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/place-main-cart', [OrderController::class, 'placeMainCart'])->name('orders.placeMainCart');
        Route::get('/{order_id}', [OrderController::class, 'show'])->name('orders.show');
    });
});

require __DIR__ . '/auth.php';
