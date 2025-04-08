<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLesson\StoreRequest;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\Lesson;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLessonControlller extends Controller
{
    use FileUpload;
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
    public function store(StoreRequest $request, Course $course, CourseChapter $chapter)
    {
        $lesson = new Lesson();
        $lesson->fill($request->validated());

        if ($request->hasFile('video_file')) {
            $lesson->file_path = $this->uploadFile($request->file('video_file'));
        } else {
            $lesson->file_path = $request['video_input'];
        }
        $lesson->instructor_id = Auth::id();
        $lesson->course_id = $course->id;
        $lesson->chapter_id = $chapter->id;
        $lesson->slug = str($request['title'])->slug();
        $lesson->save();
        return response()->json($lesson, 201);
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
    public function destroy(Course $course, CourseChapter $chapter, Lesson $lesson)
    {
        if ($lesson->course_id !== $course->id || $lesson->chapter_id !== $chapter->id) {
            return response()->json(['message' => 'Lesson not found'], 404);
        }

        if ($lesson->file_path) {
            $this->deleteFile($lesson->file_path);
        }
        $lesson->delete();
        return response()->json(['message' => 'Lesson deleted successfully'], 200);
    }
}
