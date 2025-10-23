<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin Universepedia',
            'email' => 'admin@universepedia.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Member
        User::create([
            'name' => 'Member Universpedia',
            'email' => 'member@universepedia.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
    }
}