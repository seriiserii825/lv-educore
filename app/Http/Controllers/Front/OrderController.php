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
        return $this->service->index();
    }
    public function store(StoreRequest $request)
    {
        return $this->service->store($request);
    }
    public function show(Order $order)
    {
        return $this->service->show($order);
    }
    public function hasCourseInOrderItems(Course $course)
    {
        return $this->service->hasCourseInOrderItems($course);
    }
}
