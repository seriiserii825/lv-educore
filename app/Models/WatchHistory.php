<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'chapter_id',
        'lesson_id',
        'is_completed'
    ];

    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
