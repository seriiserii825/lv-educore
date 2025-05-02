<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Services\Student\StudentEnrollmentServiceService;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    private $service;
    public function __construct(StudentEnrollmentServiceService $service)
    {
        $this->service = $service;

    }
    public function index()
    {
        return $this->service->index();
    }
    public function show(string $slug)
    {
        return $this->service->show($slug);
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
