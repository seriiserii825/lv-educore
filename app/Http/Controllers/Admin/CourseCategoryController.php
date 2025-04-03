<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::orderBy('updated_at', 'desc')->get();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CourseCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string',
            'show_at_tranding' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);
        $validated['slug'] = \Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadFile($request->file('image'));
        }

        $category = CourseCategory::create($validated);
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCategory $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string',
            'show_at_tranding' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Str::slug($validated['name']);
        if ($request->hasFile('image') && $category->image) {
            $validated['image'] = $this->uploadFile($request->file('image'), $category->image);
        }
        $category->update($validated);
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $category)
    {
        if ($category->image) {
            $this->deleteFile($category->image);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
