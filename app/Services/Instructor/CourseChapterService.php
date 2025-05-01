<?php

namespace App\Services\Instructor;

use App\Http\Requests\CourseChapter\StoreRequest;
use App\Http\Requests\CourseChapter\UpdateRequest;
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

    public function update(UpdateRequest $request, CourseChapter $chapter)
    {
        $instructor_id = Auth::user()->id;
        if ($chapter->instructor_id != $instructor_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $chapter->update($request->validated());
        return response()->json($chapter, 200);
    }
}
