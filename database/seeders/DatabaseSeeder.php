<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CourseLanguageSeeder::class,
            CourseLevelSeeder::class,
            CourseCategorySeeder::class,
            CourseSeeder::class,
            CourseChapterSeeder::class,
            LessonSeeder::class,
            HeroSeeder::class,
            // SettingsSeeder::class,
        ]);
    }
}
