<?php

namespace Database\Seeders;

use App\Models\CourseChapter;
use App\Traits\TSeeder;
use Illuminate\Database\Seeder;

class CourseChapterSeeder extends Seeder
{
    use TSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->truncateTable('course_chapters');
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
