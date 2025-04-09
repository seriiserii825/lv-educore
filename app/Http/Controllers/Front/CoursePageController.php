<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursePageController extends Controller
{
    public function index()
    {
        $courses = Course::with(['instructor'])
            ->withCount('lessons') // Correct way to count lessons
            ->where(['is_approved' => 'approved', 'status' => 'active'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return response()->json($courses, 200);
    }
}
