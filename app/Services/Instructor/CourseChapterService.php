<?php

namespace App\Services\Instructor;

use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Support\Facades\Auth;

class CourseChapterService
{
    public function index(Course $course)
    {
        $instructor_id = Auth::user()->id;
        $course_chapters = CourseChapter::where([
            'course_id' => $course->id,
            'instructor_id' => $instructor_id,
        ])->with('lessons')->get();
        if ($course_chapters->isEmpty()) {
            return response()->json(['message' => 'No chapters found'], 404);
        }
        return response()->json($course_chapters);
    }
}
