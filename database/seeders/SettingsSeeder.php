<?php

namespace Database\Seeders;

use App\Models\Settings;
use App\Traits\TSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    use TSeeder;

    public function run(): void
    {
        $this->truncateTable('settings');
        $settings = [
            'site_name' => 'My Website',
            'phone' => '123-456-7890',
            'email' => 'myemail@gmail.com',
            'address' => '123 Main St, Anytown, USA',
        ];

        Settings::create($settings);
    }
}
