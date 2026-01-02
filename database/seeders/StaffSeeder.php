<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch departments
        $finance   = Department::where('name', 'Finance')->first();
        $registrar = Department::where('name', 'Registrar')->first();
        $it        = Department::where('name', 'Information Technology')->first();
        $hod       = Department::where('name', 'Head of Department (HOD)')->first();
        $dean      = Department::where('name', 'Dean Office')->first();

        // Fetch faculties
        $science     = Faculty::where('name', 'Faculty of Science')->first();
        $engineering = Faculty::where('name', 'Faculty of Engineering')->first();
        $business    = Faculty::where('name', 'Faculty of Business')->first();

        $staffMembers = [
            [
                'name' => 'Dr. Jean Claude Niyonzima',
                'email' => 'jc.niyonzima@university.edu',
                'role' => 'staff',
                'department_id' => $dean?->id,
                'faculty_id' => $science?->id,
                'position' => 'Dean of Faculty of Science',
                'phone' => '0788123456',
            ],
            [
                'name' => 'Ms. Alice Uwimana',
                'email' => 'alice.uwimana@university.edu',
                'role' => 'staff',
                'department_id' => $finance?->id,
                'faculty_id' => null,
                'position' => 'Finance Officer',
                'phone' => '0788234567',
            ],
            [
                'name' => 'Mr. Patrick Habimana',
                'email' => 'patrick.habimana@university.edu',
                'role' => 'staff',
                'department_id' => $registrar?->id,
                'faculty_id' => null,
                'position' => 'Registrar Officer',
                'phone' => '0788345678',
            ],
            [
                'name' => 'Eng. Samuel Mugabo',
                'email' => 'samuel.mugabo@university.edu',
                'role' => 'staff',
                'department_id' => $it?->id,
                'faculty_id' => null,
                'position' => 'IT Support Lead',
                'phone' => '0788456789',
            ],
            [
                'name' => 'Dr. Grace Mukamana',
                'email' => 'grace.mukamana@university.edu',
                'role' => 'staff',
                'department_id' => $hod?->id,
                'faculty_id' => $engineering?->id,
                'position' => 'Head of Department – Engineering',
                'phone' => '0788567890',
            ],
            [
                'name' => 'Mr. Emmanuel Nkurunziza',
                'email' => 'emmanuel.nkurunziza@university.edu',
                'role' => 'staff',
                'department_id' => $hod?->id,
                'faculty_id' => $business?->id,
                'position' => 'Head of Department – Business',
                'phone' => '0788678901',
            ],
        ];

        foreach ($staffMembers as $data) {

            // 1️⃣ Create or fetch user
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                    'email_verified_at' => now(),
                ]
            );

            // 2️⃣ Create staff record
            Staff::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'staff_number' => 'STF-' . date('Y') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'department_id' => $data['department_id'],
                    'faculty_id' => $data['faculty_id'],
                    'position' => $data['position'],
                    'phone' => $data['phone'],
                ]
            );
        }
    }
}
