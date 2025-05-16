<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin user already exists
        if (! User::where('email', 'admin@example.com')->exists()) {
            // Create admin user
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Check if test user already exists
        if (! User::where('email', 'test@example.com')->exists()) {
            // Create test user
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Count existing users
        $existingCount = User::count();
        $remainingCount = 1000 - $existingCount;

        // Create additional random users if needed
        if ($remainingCount > 0) {
            User::factory()->count($remainingCount)->create();
        }
    }
}
