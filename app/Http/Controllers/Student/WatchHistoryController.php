<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    public function index()
    {
        $watch_history = WatchHistory::where('user_id', auth()->id())
            ->select('lesson_id', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

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

        // check if lesson_id exists in the table
        $lesson_id = WatchHistory::where('lesson_id', $request->lesson_id)->first();
        // if exists update, else create
        if ($lesson_id) {
            $lesson = WatchHistory::where('lesson_id', $request->lesson_id)->first();
            if ($lesson) {
                $lesson->is_completed = $request->is_completed ? 1 : 0;
                $lesson->updated_at = now();
                $lesson->save();
            }
        } else {
            $lesson = WatchHistory::create([
                'user_id' => Auth::user()->id,
                'course_id' => $request->course_id,
                'chapter_id' => $request->chapter_id,
                'lesson_id' => $request->lesson_id,
                'is_completed' => $request->is_completed ? 1 : 0,
            ]);
        }
        return response()->json([
            'is_completed' => $request->is_completed ? 1 : 0,
            'message' => 'Watch history updated successfully'
        ], 200);
    }
}
