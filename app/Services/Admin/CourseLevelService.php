<?php

namespace App\Services\Admin;

use App\Models\CourseLevel;

class CourseLevelService
{
    public function store(string $name)
    {
        $level = new CourseLevel();
        $level->name = $name;
        $level->slug = \Str::slug($name);
        $level->save();
        return $level;
    }
    public function update(CourseLevel $level, string $name)
    {
        $level->name = $name;
        $level->slug = \Str::slug($name);
        $level->save();
        return $level;
    }
}
