<?php

namespace App\Services\Admin;

use App\Http\Requests\CourseSubCategory\StoreRequest;
use App\Http\Requests\CourseSubCategory\UpdateRequest;
use App\Models\CourseCategory;
use App\Traits\FileUpload;

class CourseSubCategoryService
{
    use FileUpload;
    public function store(StoreRequest $request, CourseCategory $category)
    {
        $validated = $request->all();
        $validated['parent_id'] = $category->id;
        $validated['slug'] = \Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadFile($request->file('image'));
        }

        return CourseCategory::create($validated);
    }

    public function update(UpdateRequest $request, CourseCategory $category, CourseCategory $subcategory)
    {
        $validated = $request->all();
        $validated['slug'] = \Str::slug($validated['name']);

        if ($request->hasFile('image') && $subcategory->image) {
            $validated['image'] = $this->uploadFile($request->file('image'), $subcategory->image);
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

