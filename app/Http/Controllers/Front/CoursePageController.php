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

    public function show(string $slug)
    {
        $course = Course::with([
            'instructor' => function ($query) {
                $query->withCount('courses');
            },
            'lessons',
            'category'
        ])
            ->where(['is_approved' => 'approved', 'status' => 'active'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($course, 200);
    }
}
