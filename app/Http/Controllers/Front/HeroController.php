<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $hero = Hero::first();
        if ($hero) {
            return response()->json($hero, 200);
        }
        return response()->json(null, 404);
    }
}
