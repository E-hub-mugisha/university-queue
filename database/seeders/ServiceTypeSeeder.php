<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;
use App\Models\Department;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch departments
        $finance   = Department::where('name', 'Finance')->first();
        $registrar = Department::where('name', 'Registrar')->first();
        $it        = Department::where('name', 'Information Technology')->first();
        $hod       = Department::where('name', 'Head of Department (HOD)')->first();
        $dean      = Department::where('name', 'Dean Office')->first();
        $studentAffairs = Department::where('name', 'Student Affairs')->first();

        $services = [

            // Finance services
            ['department' => $finance, 'name' => 'Fee Clearance'],
            ['department' => $finance, 'name' => 'Invoice Generation'],
            ['department' => $finance, 'name' => 'Payment Verification'],
            ['department' => $finance, 'name' => 'Refund Request'],
            ['department' => $finance, 'name' => 'Financial Statement'],

            // Registrar services
            ['department' => $registrar, 'name' => 'Transcript Request'],
            ['department' => $registrar, 'name' => 'Enrollment Verification'],
            ['department' => $registrar, 'name' => 'Course Registration Issue'],
            ['department' => $registrar, 'name' => 'Graduation Clearance'],
            ['department' => $registrar, 'name' => 'Academic Record Correction'],

            // IT services
            ['department' => $it, 'name' => 'Student Portal Access Issue'],
            ['department' => $it, 'name' => 'Email Account Reset'],
            ['department' => $it, 'name' => 'Wi-Fi Access Issue'],
            ['department' => $it, 'name' => 'System Bug Report'],
            ['department' => $it, 'name' => 'ID Card System Issue'],

            // HOD services
            ['department' => $hod, 'name' => 'Course Add / Drop Approval'],
            ['department' => $hod, 'name' => 'Special Exam Approval'],
            ['department' => $hod, 'name' => 'Academic Appeal Review'],
            ['department' => $hod, 'name' => 'Departmental Clearance'],

            // Dean services
            ['department' => $dean, 'name' => 'Faculty Approval Request'],
            ['department' => $dean, 'name' => 'Academic Exception Approval'],
            ['department' => $dean, 'name' => 'Faculty Clearance'],
            ['department' => $dean, 'name' => 'Student Discipline Review'],

            // Student Affairs services
            ['department' => $studentAffairs, 'name' => 'Accommodation Request'],
            ['department' => $studentAffairs, 'name' => 'Counseling Appointment'],
            ['department' => $studentAffairs, 'name' => 'Student Welfare Issue'],
            ['department' => $studentAffairs, 'name' => 'Disciplinary Appeal'],
        ];

        foreach ($services as $service) {
            if (!$service['department']) {
                continue; // safety check
            }

            ServiceType::updateOrCreate(
                [
                    'department_id' => $service['department']->id,
                    'name' => $service['name'],
                ],
                []
            );
        }
    }
}
