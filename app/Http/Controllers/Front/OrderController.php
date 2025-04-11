<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buyer_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'paid_amount' => 'nullable|numeric',
            'company' => 'required|string',
            'address' => 'required|string',
        ]);

        $order = new Order();
        $order->invoice_id = uniqid('INV-');
        if ($request->paid_amount) {
            $order->paid_amount = $request->paid_amount;
        } else {
            $order->paid_amount = $request->total_amount;
        }


        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
}
