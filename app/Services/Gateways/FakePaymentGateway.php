<?php


namespace App\Services\Gateways;

use App\Services\PaymentGateway;
use App\Models\Order;
use Illuminate\Support\Str;

class FakePaymentGateway extends PaymentGateway
{
    public function processPayment(Order $order): array
    {
        // هنا محاكاة بسيطة — يمكنك إضافة منطق عشوائي إذا أردت فشل أحياناً
        $transactionId = 'FAKE-' . strtoupper(Str::random(10));

        // مثلاً نعتبر الدفع ناجح دائماً
        return [
            'success' => true,
            'transaction_id' => $transactionId,
            'message' => 'Fake payment processed.'
        ];
    }
}
