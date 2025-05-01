<?php
namespace App\Services\Front;
use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class CartService
{
    private $user_id;
    public function __construct()
    {
        $this->user_id = Auth::id();
    }
    public function index()
    {
        $cart_items = Cart::where('user_id', $this->user_id)->with('course.instructor')->get();
        if ($cart_items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 404);
        }
        return response()->json($cart_items, 200);
    }
    public function store(StoreRequest $request)
    {
        $user_courses = Cart::where('user_id', $this->user_id)->pluck('course_id')->toArray();
        if (in_array($request->course_id, $user_courses)) {
            return response()->json(['message' => 'Course already in cart'], 409);
        }
        Cart::create([
            'user_id' => $this->user_id,
            'course_id' => $request->course_id,
        ]);
        return response()->json(['message' => 'Course added to cart'], 201);
    }
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== $this->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $cart->delete();
        return response()->json(['message' => 'Course removed from cart'], 200);
    }
}
