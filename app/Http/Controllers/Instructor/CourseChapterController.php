<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseChapter\StoreRequest;
use App\Http\Requests\CourseChapter\UpdateRequest;
use App\Http\Requests\OrderLessons\StoreRequest as OrderLessonsStoreRequest;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Services\Instructor\CourseChapterService;

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
        return $this->service->store($request, $course);
    }

    public function update(UpdateRequest $request, string $chapter_id)
    {
        return $this->service->update($request, $chapter_id);
    }

    public function destroy(Course $course, string $chapter_id)
    {
        return $this->service->destroy($course, $chapter_id);
    }

    public function orderLessons(OrderLessonsStoreRequest $request, Course $course, CourseChapter $chapter)
    {
        return $this->service->orderLessons($request, $course, $chapter);
    }
}
