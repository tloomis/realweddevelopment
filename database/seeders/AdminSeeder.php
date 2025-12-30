<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Validate required environment variables
        if (empty(env('ADMIN_PASSWORD'))) {
            $this->command->error('ADMIN_PASSWORD environment variable is required!');
            $this->command->error('Please set ADMIN_PASSWORD in your .env file or Railway environment variables.');
            return;
        }

        if (empty(env('ADMIN_EMAIL'))) {
            $this->command->error('ADMIN_EMAIL environment variable is required!');
            return;
        }

        // Create admin user if doesn't exist
        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name' => env('ADMIN_NAME', 'Admin User'),
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'role' => 'admin',
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: ' . $admin->email);
            $this->command->warn('Password: Set via ADMIN_PASSWORD environment variable');
        } else {
            $this->command->info('Admin user already exists: ' . $admin->email);
        }
    }
}
