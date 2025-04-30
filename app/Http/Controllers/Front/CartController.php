<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use App\Services\Front\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    private $service;
    public function __construct(CartService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->service->index();
    }
    public function store(StoreRequest $request)
    {
        $user_id = Auth::id();
        $user_courses = Cart::where('user_id', $user_id)->pluck('course_id')->toArray();
        if (in_array($request->course_id, $user_courses)) {
            return response()->json(['message' => 'Course already in cart'], 409);
        }
        Cart::create([
            'user_id' => $user_id,
            'course_id' => $request->course_id,
        ]);
        return response()->json(['message' => 'Course added to cart'], 201);
    }
    public function destroy(Cart $cart)
    {
        $user_id = Auth::id();
        if ($cart->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $cart->delete();
        return response()->json(['message' => 'Course removed from cart'], 200);
    }
}
