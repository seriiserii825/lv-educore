<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_text' => 'required|string|max:255',
            'video_url' => 'required|url',
            'button_text' => 'required|string|max:255',
            'banner_title' => 'required|string|max:255',
            'banner_text' => 'required|string|max:255',
            'round_text' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
        // check if exists a record
        $hero = Hero::first();
        if ($hero) {
            return response()->json(['message' => 'Hero exists, try to update'], 400);
        }
        Hero::create($validated);
        return response()->json(['message' => 'Hero created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
