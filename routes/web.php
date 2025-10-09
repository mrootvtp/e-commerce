<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/shop', [ShopController::class, 'show'])->name('shop');

    Route::get('/dashboard', function () {
                return view('dashboard');
                })->name('dashboard');

    Route::get('/home', function () {
                return view('index');
                })->name('home');


                
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');

    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');

    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');

    Route::get('/search-products', [ProductController::class, 'search'])->name('search.products');

    Route::get('/product', [ProductController::class, 'show'])->name('product.show');


});

require __DIR__.'/auth.php';
