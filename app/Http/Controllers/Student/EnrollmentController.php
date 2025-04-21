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

    public function getVideo(Course $course, Lesson $lesson)
    {
        // Check if the user is enrolled in the course
        $enrollment = Enrollment::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment || !$enrollment->has_access) {
            return response()->json(['message' => 'You do not have access to this lesson.'], 403);
        }

        // Logic to get the video URL or file path
        $file_path = $lesson->file_path;

        return response()->json(['file_path' => $file_path], 200);
    }
}
