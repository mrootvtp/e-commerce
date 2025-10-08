<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;





Route::middleware('auth:sanctum')->group(function () {
    
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');

});

//   Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');