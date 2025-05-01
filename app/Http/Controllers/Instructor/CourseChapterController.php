<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseChapter\StoreRequest;
use App\Http\Requests\CourseChapter\UpdateRequest;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Services\Instructor\CourseChapterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseChapterController extends Controller
{
    private $service;
    public function __construct(CourseChapterService $service)
    {
        $this->service = $service;
    }
    public function index(Course $course)
    {
        return $this->service->index($course);
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

    public function show(string $id)
    {
        //
    }

    public function update(UpdateRequest $request, Course $course, CourseChapter $chapter)
    {
        $instructor_id = Auth::user()->id;
        if ($chapter->instructor_id != $instructor_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $chapter->update($request->validated());
        return response()->json($chapter, 200);
    }

    public function destroy(Course $course, CourseChapter $chapter)
    {
        $instructor_id = Auth::user()->id;
        if ($chapter->instructor_id != $instructor_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($chapter->course_id != $course->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($chapter->lessons()->exists()) {
            return response()->json(['message' => 'Chapter has lessons and cannot be deleted'], 403);
        }
        $chapter->delete();
        return response()->json(['message' => 'Chapter deleted successfully'], 200);
    }

    public function orderLessons(Request $request, Course $course, CourseChapter $chapter)
    {
        $request->validate([
            'lessons_ids' => 'required|array',
            'lessons_ids.*' => 'exists:lessons,id',
        ]);

        $instructor_id = Auth::user()->id;
        if ($chapter->instructor_id != $instructor_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($chapter->course_id != $course->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        // Logic to order lessons
        $lessons_ids = $request->input('lessons_ids');
        foreach ($lessons_ids as $order => $lesson_id) {
            $lesson = $chapter->lessons()->find($lesson_id);
            if ($lesson) {
                $lesson->order = $order;
                $lesson->save();
            }
        }
        return response()->json(['message' => 'Lessons ordered successfully'], 200);
    }
}
