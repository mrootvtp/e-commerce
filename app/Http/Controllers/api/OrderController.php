<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Order;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected PaymentGateway $gateway;

    public function __construct(OrderService $orderService, PaymentGateway $gateway)
    {
        $this->orderService = $orderService;
        $this->gateway = $gateway;
    }

    // POST /api/order
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'warehouse_id' => 'nullable|integer|exists:warehouses,id',
        ]);

        $user = Auth::user();
        $userId = $user ? $user->id : null;

        try {
            $order = $this->orderService->createOrder($userId, $request->items, $request->warehouse_id ?? null);

            return response()->json([
                'message' => 'Order created',
                'order_id' => $order->id,
                'order' => $order->load('items'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create order', 'error' => $e->getMessage()], 422);
        }
    }

    // POST /api/payment
    public function pay(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'payment_method' => 'nullable|string'
        ]);

        $order = Order::findOrFail($request->order_id);

        // Optional: check ownership
        if (Auth::check() && $order->user_id && Auth::id() !== $order->user_id) {
            return response()->json(['message' => 'You cannot pay this order'], 403);
        }

        // Process payment via bound gateway
        $result = $this->gateway->processPayment($order);

        if ($result['success']) {
            $order->update([
                'status' => 'paid',
                'payment_reference' => $result['transaction_id'] ?? null,
                'paid_at' => now(),
            ]);

            return response()->json(['message' => 'Payment successful', 'order' => $order]);
        }

        $order->update(['status' => 'canceled']);

        return response()->json(['message' => 'Payment failed', 'reason' => $result['message'] ?? null], 400);
    }
}
