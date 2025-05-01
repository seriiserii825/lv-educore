<?php
namespace App\Http\Controllers\Instructor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Http\Requests\Course\UpdateStep2Request;
use App\Http\Requests\Course\UpdateStep3Request;
use App\Models\Course;
use App\Services\Instructor\CourseService;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Auth;
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
        return $this->service->updateStep1($request, $course);
    }
    public function updateStep2(UpdateStep2Request $request, Course $course)
    {
        return $this->service->updateStep2($request, $course);
    }
    public function updateStep3(UpdateStep3Request $request, Course $course)
    {
        return $this->service->updateStep3($request, $course);
    }
}
