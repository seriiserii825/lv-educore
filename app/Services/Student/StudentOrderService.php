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
    public function index()
    {
        $orders = Order::with('customer')->get();
        return response()->json($orders);
    }
    public function show(Order $order)
    {
        $my_order = Order::with(['customer', 'orderItems.course.instructor'])->find($order->id);
        return response()->json($my_order, 200);
    }
    public function store(StoreRequest $request)
    {
        $cart_items = Cart::where('user_id', $request->buyer_id)->get();
        if ($cart_items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 404);
        }
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
        $this->saveEnrollments($cart_items, $order, $request->buyer_id);
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
    private function saveEnrollments($cart_items, $order, $buyer_id)
    {
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
                'user_id' => $buyer_id,
                'instructor_id' => $course->instructor_id,
                'course_id' => $item->course_id,
                'has_access' => true,
            ]);
            $item->delete();
            $order_item->save();
        }
    }
    public function hasCourseInOrderItems(Course $course)
    {
        $order = Order::whereHas('orderItems', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->first();
        if ($order) {
            return response()->json(['message' => 'Course is in order items', 'order' => $order], 200);
        } else {
            return response()->json(['message' => 'Course is not in order items', 'status' => 1], 200);
        }
    }
}
