<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    public function index(Course $course)
    {
        $watch_history = WatchHistory::where('user_id', Auth::id())
            ->where('course_id', $course->id)->get();

        return response()->json($watch_history, 200);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'chapter_id' => 'required|exists:course_chapters,id',
            'lesson_id' => 'required|exists:lessons,id',
            'is_completed' => 'boolean'
        ]);

        WatchHistory::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $request->course_id,
                'chapter_id' => $request->chapter_id,
                'lesson_id' => $request->lesson_id,
                'is_completed' => $request->is_completed,
            ]
        );

        return response()->json([
            'message' => 'Watch history updated successfully'
        ], 200);
    }
}
