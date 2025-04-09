<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'seo_description',
        'thumbnail',
        'demo_video_storage',
        'demo_video_source',
        'price',
        'discount',
        'description',
        'instructor_id',
        'category_id',
        'course_type',
        'duration',
        'timezone',
        'capacity',
        'certificate',
        'qna',
        'message_for_review',
        'is_approved',
        'status',
        'course_level_id',
        'course_language_id'
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
