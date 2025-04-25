<?php

namespace Database\Seeders;

use App\Models\Home;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $table->string('label');
        // $table->string('title');
        // $table->text('description');
        // $table->string('video_text');
        // $table->string('video_url');
        // $table->string('button_text');
        // $table->string('banner_title');
        // $table->string('banner_text');
        // $table->string('round_text');
        // $table->string('image');
        $hero = [
            'label' => 'Show Up For Learning',
            'title' => 'Premier E-Learning Courses From EduCore',
            'description' => 'We are a community of learners, teachers, and parents who believe that every child deserves the opportunity to learn and grow. We are committed to providing our students with the best possible education, and we need your help to make that happen.',
            'video_text' => 'Watch Our Video',
            'video_url' => 'https://www.youtube.com/watch?v=2g8v1j0f4aE',
            'button_text' => 'Get Started',
            'banner_title' => 'Join Our Community',
            'banner_text' => 'Explore a variety of fresh topics',
            'round_text' => 'Join Our Community and Explore a Variety of Fresh Topics',
            'image' => 'uploads/banner_3_img_1.png',
        ];
        Home::create($hero);
    }
}
