<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // avoids duplicates
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), // set your password
                'email_verified_at' => now(),
                'role' => "admin", // if your users table has an is_admin column
            ]
        );
    }
}


// php artisan migrate:fresh --seed --seeder=AdminSeeder