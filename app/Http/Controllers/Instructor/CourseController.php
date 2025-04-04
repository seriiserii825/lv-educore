<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use FileUpload;
    public function store(Request $request)
    {
        $course = new Course();
        $course->fill($request->validated());
        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $this->uploadFile($request->file('thumbnail'));
        }
        if ($request->hasFile('video_file')) {
            $course->demo_video_source = $this->uploadFile($request->file('video_file'));
        } else {
            $course->demo_video_source = $request['video_input'];
        }
        $course->instructor_id = Auth::id();
        $course->slug = Str::slug($request['title']);
        $course->save();

        // // Create the course
        // $course = Course::create($validatedData);
        //
        // return response()->json($course, 201);
    }
}
