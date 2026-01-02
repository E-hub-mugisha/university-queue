<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Department;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        // Fetch required departments
        $registrar = Department::where('name', 'Registrar')->first();
        $finance   = Department::where('name', 'Finance')->first();
        $it        = Department::where('name', 'Information Technology')->first();
        $academic  = Department::where('name', 'Academic Affairs')->first();

        $faculties = [
            [
                'name' => 'Faculty of Science',
                'department_id' => $academic?->id,
                'description' => 'Science and technology academic programs'
            ],
            [
                'name' => 'Faculty of Engineering',
                'department_id' => $academic?->id,
                'description' => 'Engineering and applied sciences'
            ],
            [
                'name' => 'Faculty of Business',
                'department_id' => $academic?->id,
                'description' => 'Business and management programs'
            ],
            [
                'name' => 'Faculty of Information Technology',
                'department_id' => $it?->id,
                'description' => 'Computer science and IT programs'
            ],
            [
                'name' => 'Finance Faculty Operations',
                'department_id' => $finance?->id,
                'description' => 'Faculty-level finance administration'
            ],
            [
                'name' => 'Registrar Faculty Office',
                'department_id' => $registrar?->id,
                'description' => 'Faculty-level registrar support'
            ],
        ];

        foreach ($faculties as $faculty) {
            // Skip if department missing (safety)
            if (!$faculty['department_id']) {
                continue;
            }

            Faculty::updateOrCreate(
                ['name' => $faculty['name']],
                $faculty
            );
        }
    }
}
