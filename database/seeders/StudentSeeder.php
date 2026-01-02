<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch departments
        $registrar = Department::where('name', 'Registrar')->first();
        $academic  = Department::where('name', 'Academic Affairs')->first();

        // Fetch faculties
        $science     = Faculty::where('name', 'Faculty of Science')->first();
        $engineering = Faculty::where('name', 'Faculty of Engineering')->first();
        $business    = Faculty::where('name', 'Faculty of Business')->first();
        $it          = Faculty::where('name', 'Faculty of Information Technology')->first();

        $students = [
            [
                'name' => 'Eric Mugisha',
                'email' => 'eric.mugisha@student.university.edu',
                'department_id' => $academic?->id,
                'faculty_id' => $it?->id,
                'program' => 'BSc Information Technology',
                'level' => 'Year 3',
                'phone' => '0789001111',
            ],
            [
                'name' => 'Aline Uwase',
                'email' => 'aline.uwase@student.university.edu',
                'department_id' => $academic?->id,
                'faculty_id' => $science?->id,
                'program' => 'BSc Computer Science',
                'level' => 'Year 2',
                'phone' => '0789002222',
            ],
            [
                'name' => 'Patrick Habimana',
                'email' => 'patrick.habimana@student.university.edu',
                'department_id' => $academic?->id,
                'faculty_id' => $engineering?->id,
                'program' => 'BEng Electrical Engineering',
                'level' => 'Year 4',
                'phone' => '0789003333',
            ],
            [
                'name' => 'Chantal Mukamana',
                'email' => 'chantal.mukamana@student.university.edu',
                'department_id' => $academic?->id,
                'faculty_id' => $business?->id,
                'program' => 'BBA Finance',
                'level' => 'Year 1',
                'phone' => '0789004444',
            ],
            [
                'name' => 'Jean Paul Niyonzima',
                'email' => 'jeanpaul.niyonzima@student.university.edu',
                'department_id' => $academic?->id,
                'faculty_id' => $science?->id,
                'program' => 'BSc Mathematics',
                'level' => 'Year 3',
                'phone' => '0789005555',
            ],
        ];

        foreach ($students as $data) {

            // 1️⃣ Create or fetch user
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'email_verified_at' => now(),
                ]
            );

            // 2️⃣ Create student record
            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'student_number' => 'STD-' . date('Y') . '-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                    'department_id' => $data['department_id'],
                    'faculty_id' => $data['faculty_id'],
                    'program' => $data['program'],
                    'level' => $data['level'],
                    'phone' => $data['phone'],
                ]
            );
        }
    }
}
