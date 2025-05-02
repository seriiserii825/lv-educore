<?php
namespace App\Services\Student;
use App\Http\Requests\StudentOrder\StoreRequest;
use App\Models\Cart;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\OrderItem;
class StudentOrderService
{
    public function store(StoreRequest $request)
    {
        $order = new Order();
        $order->fill($request->all());
        $order->invoice_id = uniqid('INV-');
        if ($request->paid_amount) {
            $order->paid_amount = $request->paid_amount;
        } else {
            $order->paid_amount = $request->total_amount;
        }
        $order->status = 'approved';
        $order->save();
        $cart_items = Cart::where('user_id', $request->buyer_id)->get();
        foreach ($cart_items as $item) {
            $order_item = new OrderItem();
            $order_item->course_id = $item->course_id;
            $order_item->order_id = $order->id;
            $order_item->qty = 1;
            $course = Course::where('id', $item->course_id)->first();
            if (!$course) {
                return response()->json(['message' => 'Course not found'], 404);
            }
            $course_price = $course->discount ?? $course->price;
            $order_item->price = $course_price;
            Enrollment::create([
                'user_id' => $request->buyer_id,
                'instructor_id' => $course->instructor_id,
                'course_id' => $item->course_id,
                'has_access' => true,
            ]);
            $item->delete();
            $order_item->save();
        }
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
}
