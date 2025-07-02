<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin Account if not exists
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]);
        }

        // Create User Account if not exists
        if (!User::where('email', 'user@user.com')->exists()) {
            User::create([
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ]);
        }
    }
}