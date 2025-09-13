<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Universepedia',
            'email' => 'admin@universepedia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Administrator of Universepedia - Space Exploration Platform',
        ]);

        User::create([
            'name' => 'Space Explorer',
            'email' => 'user@universepedia.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'bio' => 'Passionate about space exploration and astronomy',
        ]);
    }
}