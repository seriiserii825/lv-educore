<?php
namespace App\Http\Services\Admin;

use App\Models\CourseLanguage;

class CourseLanguageService {
    public function store(string $name)
    {
        $course_language = new CourseLanguage();
        $course_language->name = $name;
        $course_language->slug = \Str::slug($name);
        $course_language->save();
        return $course_language;
    }
}
?>
