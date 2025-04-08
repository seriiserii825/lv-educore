<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructor_id',
        'course_id',
        'chapter_id',
        'file_path',
        'storage',
        'file_type',
        'volume',
        'duration',
        'downloadable',
        'order',
        'is_preview',
        'status',
        'lesson_type',
    ];
}
