<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use App\Traits\TSeeder;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    use TSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateTable('course_categories');
        $categories = [
            [
                'name' => 'Development',
                'slug' => 'development',
                'show_at_tranding' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'show_at_tranding' => 0,
                'status' => 0,
            ],
            [
                'name' => 'Vue.js',
                'slug' => 'vue-js',
                'show_at_tranding' => 0,
                'status' => 1,
                'parent_id' => 1,
            ],
            [
                'name' => 'Javascript',
                'slug' => 'javascript',
                'show_at_tranding' => 0,
                'status' => 1,
                'parent_id' => 1,
            ],
        ];

        foreach ($categories as $category) {
            CourseCategory::create($category);
        }
    }
}
