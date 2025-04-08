<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\Lesson;
use Illuminate\Http\Request;

class CourseLessonControlller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, CourseChapter $chapter)
    {
        $lessons = Lesson::where(['course_id' => $course->id, 'chapter_id' => $chapter->id])->get();
        return response()->json($lessons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
