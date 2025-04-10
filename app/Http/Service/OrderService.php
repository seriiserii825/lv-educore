<?php

namespace App\Service;

use App\Models\Order;

class OrderService
{

    function storeOrder(
        int $buyer_id,
        string $status,
        float $total_amount,
        float $paid_amount,
        string $transaction_id,
        string $payment_method
    ) {
        $order = new Order();
        $order->invoice_id = uniqid();
        $order->buyer_id = $buyer_id;
        $order->status = $status;
        $order->total_amount = $total_amount;
        $order->paid_amount = $paid_amount;
        $order->transaction_id = $transaction_id;
        $order->payment_method = $payment_method;

        $order->save();
    }
}
