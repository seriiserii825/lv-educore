<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

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
}
