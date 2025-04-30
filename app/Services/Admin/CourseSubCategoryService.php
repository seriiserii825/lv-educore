<?php

namespace App\Services\Admin;

use App\Http\Requests\CourseSubCategory\StoreRequest;
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
}

