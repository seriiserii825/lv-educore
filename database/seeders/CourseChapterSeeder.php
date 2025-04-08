<?php

namespace Database\Seeders;

use App\Models\CourseChapter;
use Illuminate\Database\Seeder;

class CourseChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = [
            [
                'title' => 'Introduction to Programming',
                'course_id' => 1,
                'instructor_id' => 2,
                'order' => 1,
                'status' => 1,
            ],
            [
                'title' => 'Advanced Programming Concepts',
                'course_id' => 1,
                'instructor_id' => 2,
                'order' => 2,
                'status' => 1,
            ],
            [
                'title' => 'Data Structures and Algorithms',
                'course_id' => 1,
                'instructor_id' => 2,
                'order' => 1,
                'status' => 1,
            ],
        ];
        foreach ($chapters as $chapter) {
            CourseChapter::create($chapter);
        }
    }
}
