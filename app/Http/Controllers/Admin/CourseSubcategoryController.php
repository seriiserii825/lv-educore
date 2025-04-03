<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class CourseSubcategoryController extends Controller
{
    use FileUpload;
    public function index(CourseCategory $category)
    {
        $subcategories = $category->subcategories()->orderBy('updated_at', 'desc')->get();
        return response()->json($subcategories, 200);
    }
    public function show(CourseCategory $category, CourseCategory $subcategory)
    {
        $subcategory = $category->subcategories()->findOrFail($subcategory->id);
        return response()->json($subcategory, 200);
    }
    public function store(Request $request, CourseCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string',
            'show_at_tranding' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);
        $validated['parent_id'] = $category->id;
        $validated['slug'] = \Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadFile($request->file('image'));
        }

        $category = CourseCategory::create($validated);
        return response()->json($category, 201);
    }

    public function update(Request $request, CourseCategory $category, CourseCategory $subcategory)
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
        $subcategory = $category->subcategories()->findOrFail($subcategory->id);
        $subcategory->update($validated);
        return response()->json($subcategory, 200);
    }
}
