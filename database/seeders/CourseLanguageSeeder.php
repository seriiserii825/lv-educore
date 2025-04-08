<?php

namespace Database\Seeders;

use App\Models\CourseLanguage;
use App\Traits\TSeeder;
use Illuminate\Database\Seeder;

class CourseLanguageSeeder extends Seeder
{
    use TSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateTable('course_languages');
        $languages = [
            [
                'name' => 'English',
                'slug' => 'en',
            ],
            [
                'name' => 'Spanish',
                'slug' => 'es',
            ]
        ];

        foreach ($languages as $language) {
            CourseLanguage::create($language);
        }
    }
}
