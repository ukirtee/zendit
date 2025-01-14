<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample users
        User::factory()->count(5)->create();

        // Create admin user with known credentials for testing
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@zendit.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('password'), // Always hash passwords
        //     'remember_token' => Str::random(10),
        // ]);
    }
}
