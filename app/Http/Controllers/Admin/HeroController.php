<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hero = Hero::first();
        if ($hero) {
            return response()->json($hero, 200);
        }
        return response()->json(null);
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
        // upload image
        $validated['image'] = $this->uploadFile($request->file('image'));
        Hero::create($validated);
        return response()->json(['message' => 'Hero created successfully'], 201);
    }

    public function updateHero(Request $request, string $id)
    {
        $hero = Hero::findOrFail($id);
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
        ]);
        if ($request->hasFile('image')) {
            // validate image svg
            $request->validate([
                'image' => 'image|mimes:jpeg,jpg,png|max:2048'
            ]);
            $validated['image'] = $this->uploadFile($request->file('image'));
        } else {
            $request->validate([
                'image' => 'string|max:255'
            ]);
            $validated['image'] = $request->image;
        }
        $hero->update($validated);
        return response()->json(['message' => 'Hero updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hero = Hero::findOrFail($id);
        $hero->delete();
        return response()->json(['message' => 'Hero deleted successfully'], 200);
    }
}
