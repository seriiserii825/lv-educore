<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'icon',
        'parent_id',
        'show_at_tranding',
        'status',
    ];

    public function subcategories()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }
}
