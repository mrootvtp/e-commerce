<?php

namespace App\Services;

use App\Models\Order;

abstract class PaymentGateway
{
    /**
     * Process payment for the given order.
     * Return array: ['success' => bool, 'transaction_id' => string|null, 'message' => string|null]
     */
    abstract public function processPayment(Order $order): array;
}
