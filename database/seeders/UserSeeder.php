<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\TSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    use TSeeder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->truncateTable('users');
        $users = [
            [
                'name' => 'Student',
                'email' => 'student@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'student',
                'approve_status' => 'initial',
                'image' => '/images/green-man.jpg'
            ],
            [
                'name' => 'Laravel Daily',
                'email' => 'instructor@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'instructor',
                'approve_status' => 'initial',
                'image' => '/images/povilas-corop.jpg',
                'headline' => 'Laravel Daily',
                'facebook' => 'https://www.facebook.com/laraveldaily',
                'twitter' => 'https://twitter.com/laraveldaily',
            ],
            [
                'name' => 'Net Ninja',
                'email' => 'net-ninja@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'instructor',
                'approve_status' => 'initial',
                'image' => '/images/net-ninja.jpg',
                'headline' => 'Youtube IT Channel',
                'bio' => 'The Net Ninja is a YouTube channel that offers free web development tutorials.',
                'website' => 'https://www.thenetninja.co.uk/',
                'facebook' => 'https://www.facebook.com/thenetninja',
                'twitter' => 'https://twitter.com/netninja',
                'linkedin' => 'https://www.linkedin.com/in/netninja/',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'approve_status' => 'initial',
                'image' => '/images/green-man.jpg'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
