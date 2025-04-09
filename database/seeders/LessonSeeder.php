<?php

namespace Database\Seeders;

use App\Traits\TSeeder;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    use TSeeder;
    public function run(): void
    {
        $this->truncateTable('lessons');
        $lessons = [
            [
                'title' => "Let's Test Your Laravel Routing Skills: Complete 12 Tasks",
                'slug' => 'lets-test-your-laravel-routing-skills-complete-12-tasks',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=pENlD3izA3Q&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=1',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 1,
            ],
            [
                'title' => "Let's Test Your Laravel Blade Skills: Complete 8 Tasks",
                'slug' => 'lets-test-your-laravel-blade-skills-complete-8-tasks',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=P8s7UHuUhbg&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=2',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 1,
            ],
            [
                'title' => 'Test Your Laravel Auth Skills: 7 Tasks to Complete',
                'slug' => 'test-your-laravel-auth-skills-7-tasks-to-complete',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=v_3NmwtN_S0&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=3',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 1,
            ],
            [
                'title' => 'Test Your Laravel Migrations Skills: 10 Tasks to Complete',
                'slug' => 'test-your-laravel-migrations-skills-10-tasks-to-complete',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=tPU1hNKI_lc&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=4',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 2,
            ],
            [
                'title' => 'Test Your Eloquent Basic Skills: 11 Tasks to Complete',
                'slug' => 'test-your-eloquent-basic-skills-11-tasks-to-complete',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=AmvLs9sRSH8&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=5',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 2,
            ],
            [
                'title' => 'Test Your Eloquent Relationships Skills: 9 Tasks to Complete',
                'slug' => 'test-your-eloquent-relationships-skills-9-tasks-to-complete',
                'description' => 'This is the third lesson.',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=ohj0Mc09DyE&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=6',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 2,
            ],
            [
                'title' => 'Test Your Laravel Validation Skills: Complete 9 Tasks',
                'slug' => 'test-your-laravel-validation-skills-complete-9-tasks',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=3ihjumeOMV4&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=7',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 3,
            ],
            [
                'title' => 'Test Your Laravel File Upload Skills: Complete 7 Tasks',
                'slug' => 'test-your-laravel-file-upload-skills-complete-7-tasks',
                'description' => '',
                'file_type' => 'video',
                'storage' => 'youtube',
                'file_path' => 'https://www.youtube.com/watch?v=_SrQRnOx3q8&list=PLdXLsjL7A9k2-4sY2rLgB89MQQK0QeHvs&index=8',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 3,
            ],
        ];
        foreach ($lessons as $lesson) {
            \App\Models\Lesson::create($lesson);
        }
    }
}
