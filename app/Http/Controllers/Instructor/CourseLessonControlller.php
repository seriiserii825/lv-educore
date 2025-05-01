<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLesson\StoreRequest;
use App\Http\Requests\CourseLesson\UpdateRequest;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\Lesson;
use App\Services\Instructor\InstructorCourseLessonsService;
use App\Traits\FileUpload;

class CourseLessonControlller extends Controller
{
    use FileUpload;
    private $service;
    public function __construct(InstructorCourseLessonsService $service) {
        $this->service = $service;
    }

    public function index(Course $course, CourseChapter $chapter)
    {
        $lessons = Lesson::where(['course_id' => $course->id, 'chapter_id' => $chapter->id])->get();
        return response()->json($lessons);
    }

    public function store(StoreRequest $request, Course $course, string $chapter_id)
    {
        return $this->service->store($request, $course, $chapter_id);
    }

    public function update()
    {
//
    }

    public function updateMethod(UpdateRequest $request, Course $course, CourseChapter $chapter, Lesson $lesson)
    {
        return $this->service->update($request, $course, $chapter, $lesson);
    }

    public function destroy(Course $course, CourseChapter $chapter, Lesson $lesson)
    {
        return $this->service->destroy($course, $chapter, $lesson);
    }
}
