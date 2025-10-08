<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Api\OrderController;





Route::middleware('auth:sanctum')->group(function () {
    
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
        Route::post('/order', [OrderController::class, 'store']);
        Route::post('/payment', [OrderController::class, 'pay']);

        

});

//   Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');