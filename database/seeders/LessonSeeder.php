<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            [
                'title' => 'lesson 1',
                'slug' => 'lesson-1',
                'description' => 'This is the first lesson.',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 1,
            ],
            [
                'title' => 'lesson 2',
                'slug' => 'lesson-2',
                'description' => 'This is the second lesson.',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 1,
            ],
            [
                'title' => 'lesson 3',
                'slug' => 'lesson-3',
                'description' => 'This is the third lesson.',
                'instructor_id' => 2,
                'course_id' => 1,
                'chapter_id' => 1,
            ],
        ];
        foreach ($lessons as $lesson) {
            \App\Models\Lesson::create($lesson);
        }
    }
}
