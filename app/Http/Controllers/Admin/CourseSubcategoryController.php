<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseSubcategoryController extends Controller
{
    public function index(CourseCategory $category)
    {
        $subcategories = $category->subcategories()->get();
        return response()->json($subcategories, 200);
    }
}
