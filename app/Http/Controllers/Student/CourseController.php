<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        // Logic to get all courses
        return response()->json([
            'message' => 'List of courses',
            'data' => []
        ]);
    }
}
