<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            FacultySeeder::class,
            StaffSeeder::class,
            StudentSeeder::class,
            ServiceTypeSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
