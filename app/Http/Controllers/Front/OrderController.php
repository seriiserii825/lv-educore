<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
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
        $order->fill($request->all());
        $order->invoice_id = uniqid('INV-');
        if ($request->paid_amount) {
            $order->paid_amount = $request->paid_amount;
        } else {
            $order->paid_amount = $request->total_amount;
        }
        $order->status = 'pending';
        $order->save();

        $cart_items = Cart::where('user_id', $request->buyer_id)->get();
        foreach ($cart_items as $item) {
            $order_item = new OrderItem();
            $order_item->course_id = $item->id;
            $order_item->order_id = $order->id;
            $order_item->qty = 1;
            $course = Course::where('id', $item->course_id)->first();
            if (!$course) {
                return response()->json(['message' => 'Course not found'], 404);
            }
            $course_price = $course->discount ?? $course->price;
            $order_item->price = $course_price;
            $order_item->save();
            $item->delete();
        }

        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
}
