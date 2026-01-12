<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $offices = [
            [
                'name' => 'Registrar',
                'description' => 'Handles student registration, transcripts, and academic records'
            ],
            [
                'name' => 'Finance',
                'description' => 'Responsible for fees, payments, and financial clearance'
            ],
            [
                'name' => 'Academic Affairs',
                'description' => 'Oversees academic policies and programs'
            ],
            [
                'name' => 'Information Technology',
                'description' => 'Provides IT support and system access services'
            ],
            [
                'name' => 'Human Resources',
                'description' => 'Manages staff recruitment and employment records'
            ],
            [
                'name' => 'Dean Office',
                'description' => 'Faculty-level academic administration'
            ],
            [
                'name' => 'Head of Department (HOD)',
                'description' => 'Departmental academic leadership and approvals'
            ],
            [
                'name' => 'Library Services',
                'description' => 'Library access, clearance, and resource management'
            ],
            [
                'name' => 'Student Affairs',
                'description' => 'Handles student welfare, counseling, and discipline'
            ],
        ];

        foreach ($offices as $office) {
            Office::updateOrCreate(
                ['name' => $office['name']],
                $office
            );
        }
    }
}
