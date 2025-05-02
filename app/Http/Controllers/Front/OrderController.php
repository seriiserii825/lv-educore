<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentOrder\StoreRequest;
use App\Models\Course;
use App\Models\Order;
use App\Services\Student\StudentOrderService;
class OrderController extends Controller
{
    private $service;
    public function __construct(StudentOrderService $service) {
        $this->service = $service;
    }
    public function index()
    {
        $orders = Order::with('customer')->get();
        return response()->json($orders);
    }
    public function store(StoreRequest $request)
    {
        return $this->service->store($request);
    }
    public function show(Order $order)
    {
        $my_order = Order::with(['customer', 'orderItems.course.instructor'])->find($order->id);
        return response()->json($my_order, 200);
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
