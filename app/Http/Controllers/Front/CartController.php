<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use App\Services\Front\CartService;
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
        return $this->service->store($request);
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
