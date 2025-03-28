<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Student',
                'email' => 'student@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'student',
                'approve_status' => 'initial',
            ],
            [
                'name' => 'Instructor',
                'email' => 'instructor@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'instructor',
                'approve_status' => 'initial',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'approve_status' => 'initial',
            ],
        ];

        User::insert($users);
    }
}
