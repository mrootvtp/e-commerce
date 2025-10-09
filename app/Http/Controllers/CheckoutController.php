<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\Gateways\FakePaymentGateway;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
       
        $user = Auth::user();
        if (!$user) {
        return redirect()->route('login');
       }

    $orders = Order::where('user_id', $user->id)
                   ->where('status', 'pending')
                   ->latest()
                   ->first();


    if (!$orders) {
        return redirect()->route('cart')->with('error', 'No orders found.');
    }

    $orderItems = OrderItem::where('order_id', $orders->id)
                        ->with('product')
                        ->get();

    return view('checkout', ['order' => $orders, 'orderItems' => $orderItems, ]);

    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->firstOrFail();

        return DB::transaction(function () use ($cart, $user) {

           
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $cart->items->sum(fn($item) => $item->product->price * $item->quantity),
                'status' => 'pending',
            ]);

           
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->price,
                ]);
            }

            // تنفيذ الدفع الوهمي
            $gateway = new FakePaymentGateway();
            $paymentResult = $gateway->processPayment($order);

            if ($paymentResult['status'] === 'success') {
                $order->update(['status' => 'completed']);
                $cart->items()->delete(); 
            }

            return redirect()->route('cart.show')->with('success', 'Order placed successfully!');
        });
    }
}
