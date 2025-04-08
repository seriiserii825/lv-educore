<?php

namespace Database\Seeders;

use App\Models\CourseLevel;
use App\Traits\TSeeder;
use Illuminate\Database\Seeder;

class CourseLevelSeeder extends Seeder
{
    use TSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateTable('course_levels');
        $levels = [
            [
                'name' => 'Beginner',
                'slug' => 'beginner',
            ],
            [
                'name' => 'Intermediate',
                'slug' => 'intermediate',
            ],
            [
                'name' => 'Advanced',
                'slug' => 'advanced',
            ]
        ];
        foreach ($levels as $level) {
            CourseLevel::create($level);
        }
    }
}
