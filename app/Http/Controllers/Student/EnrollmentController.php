<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        $courses = Enrollment::with(['course','instructor'])
            ->where('user_id', auth()->id())
            ->where('has_access', true)
            ->get();
        // Logic to get all courses
        return response()->json($courses, 200);
    }
}
