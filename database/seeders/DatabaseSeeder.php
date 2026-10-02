<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@microsoftclub.com.bd'],
            [
                'name' => 'System Administrator',
                'phone' => '01342325558',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => true,
            ]
        );

        // 2. Demo Normal User
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Tanvir Ahmed',
                'phone' => '01711002233',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => true,
            ]
        );
    }
}
