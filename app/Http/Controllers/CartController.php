<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItems;

use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

     
        $cartItem = CartItems::where('cart_id', $cart->id)
                             ->where('product_id', $product->id)
                             ->first();

        if ($cartItem) {
            
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
           
            CartItems::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully']);
    }


    public function viewCart()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
        return view('cart', ['items' => [], 'cart' => null, 'total' => 0]);
    }


        $cartItems = CartItems::where('cart_id', $cart->id)
                              ->with('product')
                              ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart', ['items' => $cartItems, 'total' => $total,]);
    }   

}
