<?php

namespace App\Services\Instructor;

use App\Http\Requests\CourseChapter\StoreRequest;
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

    public function store(StoreRequest $request, Course $course)
    {
        $instructor_id = Auth::user()->id;
        $course_chapter = new CourseChapter($request->validated());
        $course_chapter->instructor_id = $instructor_id;
        $course_chapter->course_id = $course->id;
        $course_chapter->save();
        return response()->json($course_chapter, 201);
    }
}
