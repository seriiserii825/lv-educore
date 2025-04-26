<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Home;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $home = Home::first();
        if ($home) {
            return response()->json($home, 200);
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
        $home = Home::first();
        if ($home) {
            return response()->json(['message' => 'Home exists, try to update'], 400);
        }
        // upload image
        $validated['image'] = $this->uploadFile($request->file('image'));
        $home = Home::create($validated);
        return response()->json(['message' => 'Home created successfully', 'home' => $home], 201);
    }

    public function updateHome(Request $request, string $id)
    {
        $home = Home::findOrFail($id);
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
        $home->update($validated);
        return response()->json(['message' => 'Home updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $home = Home::findOrFail($id);
        $home->delete();
        return response()->json(['message' => 'Home deleted successfully'], 200);
    }
}
