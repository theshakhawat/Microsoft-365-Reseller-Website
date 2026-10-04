<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { // 1. Admin User
        User::updateOrCreate(
            ['email' => 'shakhawat9083@gmail.com'],
            [
                'name' => 'System Administrator',
                'phone' => '01342325558',
                'password' => Hash::make('shakhawat9083@gmail.com'),
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
