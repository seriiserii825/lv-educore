<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Traits\TSeeder;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    use TSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateTable('courses');
        $courses = [
            [
                'title' => 'Test Your Laravel Skills',
                'slug' => 'test-your-laravel-skills',
                'seo_description' => "How well do you know Laravel Routing features? Let's test your knowledge.",
                'thumbnail' => '/images/laravel.png',
                'demo_video_storage' => 'youtube',
                'demo_video_source' => 'https://www.youtube.com/watch?v=pENlD3izA3Q&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs',
                'price' => 600,
                'discount' => 500,
                'description' => "How well do you know Laravel Routing features? Let's test your knowledge.",
                'category_id' => 1,
                'instructor_id' => 2,
                'course_level_id' => 1,
                'course_language_id' => 1,
            ]
        ];

        foreach ($courses as $course) {
            $new_course = new Course();
            $new_course = $new_course->fill($course);
            $new_course->save();
        }
    }
}
