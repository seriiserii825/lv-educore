<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'My Website',
            'phone' => '123-456-7890',
            'email' => 'myemail@gmail.com',
            'address' => '123 Main St, Anytown, USA',
        ];

        Settings::create($settings);
    }
}
