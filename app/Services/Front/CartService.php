<?php
namespace App\Services\Front;
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
}
