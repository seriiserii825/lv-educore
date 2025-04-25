<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero = Home::first();
        if ($hero) {
            return response()->json($hero, 200);
        }
        return response()->json(null, 404);
    }
}
