<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCategory\StoreRequest;
use App\Http\Requests\CourseCategory\UpdateRequest;
use App\Models\CourseCategory;
use App\Services\Admin\CourseCategoryService;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    use FileUpload;

    private $service;

    public function __construct(CourseCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $categories = CourseCategory::with('subcategories')->whereNull('parent_id')->orderBy('updated_at', 'desc')->get();
        return response()->json($categories);
    }

    public function store(StoreRequest $request)
    {
        $category = $this->service->store($request);
        return response()->json($category, 201);
    }

    public function show(CourseCategory $category)
    {
        return response()->json($category);
    }

    public function update(UpdateRequest $request, CourseCategory $category)
    {
        $category = $this->service->update($category, $request);
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $category)
    {
        // Check if the category has subcategories
        if ($category->subcategories()->exists()) {
            return response()->json(['message' => 'Cannot delete category with subcategories!!!'], 400);
        }
        if ($category->image) {
            $this->deleteFile($category->image);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
