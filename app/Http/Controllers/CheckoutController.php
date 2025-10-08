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
    public function showCart()
    {
        $cart = Cart::with('items.product')->where('user_id', Auth::user()->id)->first();

        if (!$cart) {
            return view('cart', ['items' => []]);
        }

        return view('cart', ['items' => $cart->items]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->firstOrFail();

        return DB::transaction(function () use ($cart, $user) {

            // إنشاء الطلب
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $cart->items->sum(fn($item) => $item->product->price * $item->quantity),
                'status' => 'pending',
            ]);

            // نسخ العناصر إلى order_items
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
                $order->update(['status' => 'paid']);
                $cart->items()->delete(); // تفريغ السلة بعد الدفع
            }

            return redirect()->route('cart.show')->with('success', 'Order placed successfully!');
        });
    }
}
