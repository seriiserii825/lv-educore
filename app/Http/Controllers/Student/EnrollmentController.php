<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Http\Request;
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
        $course = Course::where('slug', $slug)->with(['chapters.lessons', 'lessons'])->firstOrFail();
        if (Enrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->exists()) {
            return response()->json($course, 200);
        } else {
            return response()->json(['message' => 'You are not enrolled in this course.'], 403);
        }
    }
    public function getVideo(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $lesson = Lesson::where('id', $request->lesson_id)
            ->where('course_id', $request->course_id)
            ->firstOrFail();

        $file_path = $lesson->file_path;

        return response()->json([
            'file_path' => $file_path,
        ], 200);
    }
}
