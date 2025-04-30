<?php

namespace App\Services\Admin;

use App\Http\Requests\CourseCategory\StoreRequest;
use App\Http\Requests\CourseCategory\UpdateRequest;
use App\Models\CourseCategory;
use App\Traits\FileUpload;

class CourseCategoryService
{
    use FileUpload;
    public function store(StoreRequest $request)
    {
        $course_category = new CourseCategory();
        $course_category->name = $request->name;
        if ($request->hasFile('image')) {
            $course_category->image = $this->uploadFile($request->file('image'));
        }
        $course_category->icon = $request->icon;
        $course_category->show_at_tranding = $request->show_at_tranding;
        $course_category->status = $request->status;
        $course_category->slug = \Str::slug($request->name);
        return $course_category;
    }

    public function update(CourseCategory $category, UpdateRequest $request)
    {
        $validated = $request->all();
        $validated['slug'] = \Str::slug($validated['name']);
        if ($request->hasFile('image') && $category->image) {
            $validated['image'] = $this->uploadFile($request->file('image'), $category->image);
        }
        $category->update($validated);
        return $category;
    }
}

