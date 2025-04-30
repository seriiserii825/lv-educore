<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSubCategory\StoreRequest;
use App\Models\CourseCategory;
use App\Services\Admin\CourseSubCategoryService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class CourseSubcategoryController extends Controller
{
    use FileUpload;
    private $service;
    public function __construct(CourseSubCategoryService $service)
    {
        $this->service = $service;
    }

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
    public function store(StoreRequest $request, CourseCategory $category)
    {
        $category = $this->service->store($request, $category);
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
    public function destroy(CourseCategory $category, CourseCategory $subcategory)
    {
        $subcategory = $category->subcategories()->findOrFail($subcategory->id);
        if ($subcategory->image) {
            $this->deleteFile($subcategory->image);
        }
        $subcategory->delete();
        return response()->json(['message' => 'Subcategory deleted successfully'], 200);
    }
}
