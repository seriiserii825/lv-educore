<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['instructor'])->get();
        return response()->json($courses);
    }
    public function updateApproved(Request $request, Course $course)
    {
        $validated = $request->validate([
            'is_approved' => 'required|in:pending,approved,rejected',
        ]);

        $course->is_approved = $validated['is_approved'];
        $course->save();
        return response()->json(['message' => 'Course approval status updated successfully.']);
    }
}
