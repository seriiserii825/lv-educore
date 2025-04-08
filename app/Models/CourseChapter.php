<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseChapter extends Model
{
    protected $fillable = [
        'title',
        'course_id',
        'instructor_id',
        'order',
        'status',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'chapter_id', 'id');
    }
}
