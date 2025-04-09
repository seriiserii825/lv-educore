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
                'image' => '/images/povilas-corop.jpg'
            ],
            [
                'name' => 'Net Ninja',
                'email' => 'net-ninja@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'instructor',
                'approve_status' => 'initial',
                'image' => '/images/net-ninja.jpg'
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

        User::insert($users);
    }
}
