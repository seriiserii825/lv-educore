<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $courses = Enrollment::with(['course', 'instructor'])
            ->where('user_id', auth()->id())
            ->where('has_access', true)
            ->get();
        // Logic to get all courses
        return response()->json($courses, 200);
    }
    public function show(string $slug)
    {
        $course = Course::where('slug', $slug)->with(['chapters.lessons', 'lessons'])->firstOrFail();
        $watch_history = WatchHistory::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->get();
        if (Enrollment::where('user_id', Auth::user()->id)->where('course_id', $course->id)->exists()) {
            $history_chapters = $watch_history->pluck('chapter_id')->unique();
            $history_lessons = $watch_history->pluck('lesson_id')->unique();
            $chapter_lessons = $course->chapters->map(function ($chapter) use ($history_chapters, $history_lessons) {
                $current_chapter_lessons = [];
                if ($history_chapters->contains($chapter->id)) {
                    foreach ($chapter->lessons as $lesson) {
                        if ($history_lessons->contains($lesson->id)) {
                            $current_chapter_lessons[] = [
                                'id' => $lesson->id,
                                'is_completed' => WatchHistory::where('user_id', Auth::user()->id)
                                    ->where('course_id', $lesson->course_id)
                                    ->where('chapter_id', $lesson->chapter_id)
                                    ->where('lesson_id', $lesson->id)
                                    ->first()
                                    ?->is_completed,
                            ];
                        }                    }
                }
                return [
                    'chapter' => $chapter->id,
                    'lessons' => $current_chapter_lessons,
                ];
            });
            return response()->json([
                'course' => $course,
                'chapter_lessons' => $chapter_lessons,
            ], 200);
        } else {
            return response()->json(['message' => 'You are not enrolled in this course.'], 403);
        }
    }

    public function getVideo(Course $course, Lesson $lesson)
    {
        // Check if the user is enrolled in the course
        $enrollment = Enrollment::where('user_id', Auth::user()->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment || !$enrollment->has_access) {
            return response()->json(['message' => 'You do not have access to this lesson.'], 403);
        }

        // Logic to get the video URL or file path
        $file_path = $lesson->file_path;

        return response()->json(['file_path' => $file_path], 200);
    }
}
