<?php

namespace App\Services\Instructor;

use App\Http\Requests\CourseLesson\StoreRequest;
use App\Models\Course;
use App\Models\CourseChapter;
use App\Models\Lesson;
use App\Http\Requests\CourseLesson\UpdateRequest;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Auth;

class InstructorCourseLessonsService
{
    use FileUpload;

    public function store(StoreRequest $request, Course $course, $chapter_id)
    {
        $chapter = CourseChapter::findOrFail($chapter_id);
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

    public function update(UpdateRequest $request, Course $course, CourseChapter $chapter, Lesson $lesson)
    {
        $lesson->fill($request->validated());
        if ($request->hasFile('video_file')) {
            if ($lesson->file_path) {
                $this->deleteFile($lesson->file_path);
            }
            $lesson->file_path = $this->uploadFile($request->file('video_file'));
        } else {
            $lesson->file_path = $request['video_input'];
        }
        $lesson->instructor_id = Auth::id();
        $lesson->course_id = $course->id;
        $lesson->chapter_id = $chapter->id;
        $lesson->slug = str($request['title'])->slug();
        $lesson->save();
        return response()->json($lesson, 200);
    }
}
