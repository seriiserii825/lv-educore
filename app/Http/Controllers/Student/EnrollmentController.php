<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $courses = Enrollment::with(['course', 'instructor'])
            ->where('user_id', auth()->id())
            ->where('has_access', true)
            ->get();
        // Logic to get all courses
        return response()->json($courses, 200);
    }
    public function show(string $slug)
    {
        $course = Course::where('slug', $slug)->with(['chapters.lessons'])->firstOrFail();
        if (Enrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->exists()) {
            return response()->json($course, 200);
        } else {
            return response()->json(['message' => 'You are not enrolled in this course.'], 403);
        }
    }
}
