<?php
namespace App\Services\Admin;

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
    public function update(CourseLanguage $language, string $name)
    {
        $language->slug = \Str::slug($name);
        $language->update([
            'name' => $name,
            'slug' => $language->slug,
        ]);
        return $language;
    }
}
?>
