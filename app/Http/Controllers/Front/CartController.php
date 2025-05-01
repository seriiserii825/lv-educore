<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use App\Services\Front\CartService;
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
        return $this->service->destroy($cart);
    }
}
