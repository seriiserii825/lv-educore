<?php
namespace App\Services\Instructor;
use App\Http\Requests\Course\StoreRequest;
use App\Models\Course;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Auth;
class CourseService {
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
}
