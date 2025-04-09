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
                'title' => 'Easy Skills',
                'course_id' => 1,
                'instructor_id' => 2,
                'order' => 1,
                'status' => 1,
            ],
            [
                'title' => 'Advanced Skills',
                'course_id' => 1,
                'instructor_id' => 2,
                'order' => 2,
                'status' => 1,
            ],
            [
                'title' => 'Master Skills',
                'course_id' => 1,
                'instructor_id' => 2,
                'order' => 3,
                'status' => 1,
            ],
        ];
        foreach ($chapters as $chapter) {
            CourseChapter::create($chapter);
        }
    }
}
