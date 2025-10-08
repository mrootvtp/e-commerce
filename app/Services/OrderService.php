<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\Inventory_transaction;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    /**
     * Create order from cart items and deduct inventory.
     *
     */
    public function createOrder($userId = null, array $items, ?int $warehouseId = null): Order
    {
        return DB::transaction(function () use ($userId, $items, $warehouseId) {
            $total = 0;
            foreach ($items as $it) {
                $total += (float)$it['price'] * (int)$it['quantity'];
            }

            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $total,
                'status' => 'pending',
            ]);

            foreach ($items as $it) {
                $productId = $it['product_id'];
                $qty = (int)$it['quantity'];
                $price = (float)$it['price'];

                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'price' => $price,
                ]);

                // إدارة المخزون إن وجد
                $inventory = Inventory::where('product_id', $productId)
                                      ->when($warehouseId, fn($q) => $q->where('warehouse_id', $warehouseId))
                                      ->lockForUpdate()
                                      ->first();

                if (!$inventory) {
                    throw new Exception("Inventory for product {$productId} not found.");
                }

                if ($inventory->quantity < $qty) {
                    throw new Exception("Insufficient stock for product {$productId} (available {$inventory->quantity}).");
                }

                $before = $inventory->quantity;
                $inventory->decrement('quantity', $qty);
                $after = $inventory->quantity;

                Inventory_transaction::create([
                    'inventory_id' => $inventory->id,
                    'order_id' => $order->id,
                    'type' => 'OUT',
                    'quantity' => $qty,
                    'before_qty' => $before,
                    'after_qty' => $after,
                    'notes' => "Order #{$order->id} checkout",
                ]);
            }

            return $order;
        });
    }
}
