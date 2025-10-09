<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController;




Route::middleware('auth:sanctum')->group(function () {
    
        Route::post('/order', [OrderController::class, 'store']);
        Route::post('/payment', [OrderController::class, 'pay']);
        Route::delete('/cart/item/{id}', [CartController::class, 'destroy'])->name('cart.item.remove');
        
        Route::apiResource('products', ProductController::class);


        Route::get('/search', [ProductController::class, 'search']);

});


