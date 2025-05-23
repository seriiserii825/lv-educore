<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
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

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }
    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }

    public function language()
    {
        return $this->belongsTo(CourseLanguage::class, 'course_language_id');
    }

    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }
}
