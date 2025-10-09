<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItems;

class CartController extends Controller
{
    
    public function destroy($productId)
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)->first();

    if (!$cart) return response()->json(['message' => 'Cart not found'], 404);

    $cartItem = CartItems::where('cart_id', $cart->id)
                         ->where('product_id', $productId)
                         ->first();

    if (!$cartItem) return response()->json(['message' => 'Item not found'], 404);

    $cartItem->delete();

    return response()->json(['message' => 'Item removed from cart']);
}

}
