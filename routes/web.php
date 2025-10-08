<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

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


    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');

});

require __DIR__.'/auth.php';
