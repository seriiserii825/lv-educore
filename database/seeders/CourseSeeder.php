<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $courses = [
            [
                'title' => 'Course Title',
                'slug' => 'course-title',
                'seo_description' => 'Course SEO Description',
                'thumbnail' => 'thumbnail.jpg',
                'demo_video_storage' => 'youtube',
                'demo_video_source' => 'demo_video.mp4',
                'price' => 100,
                'discount' => 10,
                'description' => 'Course Description',
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
