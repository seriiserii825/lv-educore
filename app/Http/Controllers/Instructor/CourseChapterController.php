<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseChapter\StoreRequest;
use App\Http\Requests\CourseChapter\UpdateRequest;
use App\Models\Course;
use App\Models\CourseChapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $instructor_id = Auth::user()->id;
        $course_chapters = CourseChapter::where([
            'course_id' => $course->id,
            'instructor_id' => $instructor_id,
        ])->get();
        if ($course_chapters->isEmpty()) {
            return response()->json(['message' => 'No chapters found'], 404);
        }
        return response()->json($course_chapters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Course $course)
    {
        $instructor_id = Auth::user()->id;
        $course_chapter = new CourseChapter($request->validated());
        $course_chapter->instructor_id = $instructor_id;
        $course_chapter->course_id = $course->id;
        $course_chapter->save();
        return response()->json($course_chapter, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Course $course, CourseChapter $chapter)
    {
        $instructor_id = Auth::user()->id;
        if ($chapter->instructor_id != $instructor_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $chapter->update($request->validated());
        return response()->json($chapter, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, CourseChapter $chapter)
    {
        $instructor_id = Auth::user()->id;
        if ($chapter->instructor_id != $instructor_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($chapter->course_id != $course->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $chapter->delete();
        return response()->json(['message' => 'Chapter deleted successfully'], 200);
    }
}
