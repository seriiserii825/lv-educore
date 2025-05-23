<?php

namespace App\Services\Instructor;

use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Http\Requests\Course\UpdateStep2Request;
use App\Http\Requests\Course\UpdateStep3Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLanguage;
use App\Models\CourseLevel;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Auth;

class CourseService
{
    use FileUpload;
    public function store(StoreRequest $request)
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
        $course->price = $request['price'] ?? 0;
        $course->discount = $request['discount'] ?? 0;
        $course->instructor_id = Auth::id();
        $course->slug = \Str::slug($request['title']);
        $course->save();
        return response($course, 201);
    }
    public function step2(Course $course)
    {
        $categories = CourseCategory::where('status', 1)->get();
        $levels = CourseLevel::all();
        $languages = CourseLanguage::all();
        return response()->json([
            'course' => $course,
            'categories' => $categories,
            'levels' => $levels,
            'languages' => $languages,
        ], 200);
    }
    public function updateStep1(UpdateRequest $request, Course $course)
    {
        $course->fill($request->validated());
        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $this->uploadFile($request->file('thumbnail'));
        } else {
            $course->thumbnail = $request['thumbnail'];
        }
        if ($request->hasFile('video_file')) {
            $course->demo_video_source = $this->uploadFile($request->file('video_file'));
        } else {
            $course->demo_video_source = $request['video_input'];
        }
        $course->price = $request['price'] ?? 0;
        $course->discount = $request['discount'] ?? 0;
        $course->slug = \Str::slug($request['title']);
        $course->save();
        return response($course, 200);
    }
    public function updateStep2(UpdateStep2Request $request, Course $course)
    {
        $course->fill($request->validated());
        $course->save();
        return response($course, 200);
    }
    public function updateStep3(UpdateStep3Request $request, Course $course)
    {
        $course->fill($request->validated());
        $course->save();
        return response($course, 200);
    }
}

