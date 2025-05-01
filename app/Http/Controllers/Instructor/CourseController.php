<?php
namespace App\Http\Controllers\Instructor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Http\Requests\Course\UpdateStep2Request;
use App\Http\Requests\Course\UpdateStep3Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLanguage;
use App\Models\CourseLevel;
use App\Services\Instructor\CourseService;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CourseController extends Controller
{
    use FileUpload;
    private $service;
    public function __construct(CourseService $service)
    {
        return $this->service = $service;
    }
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->orderBy('updated_at', 'desc')->get();
        return response($courses, 200);
    }
    public function show(Course $course)
    {
        return response()->json($course, 200);
    }
    public function store(StoreRequest $request) {
        return $this->service->store($request);
    }
    public function step2(Course $course)
    {
        return $this->service->step2($course);
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
        $course->slug = Str::slug($request['title']);
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
