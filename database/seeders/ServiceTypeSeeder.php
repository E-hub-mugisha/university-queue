<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;
use App\Models\Office;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch departments
        $finance   = Office::where('name', 'Finance')->first();
        $registrar = Office::where('name', 'Registrar')->first();
        $it        = Office::where('name', 'Information Technology')->first();
        $hod       = Office::where('name', 'Head of Department (HOD)')->first();
        $dean      = Office::where('name', 'Dean Office')->first();
        $studentAffairs = Office::where('name', 'Student Affairs')->first();
        
        $services = [

            // Finance services
            ['office' => $finance, 'name' => 'Fee Clearance'],
            ['office' => $finance, 'name' => 'Invoice Generation'],
            ['office' => $finance, 'name' => 'Payment Verification'],
            ['office' => $finance, 'name' => 'Refund Request'],
            ['office' => $finance, 'name' => 'Financial Statement'],

            // Registrar services
            ['office' => $registrar, 'name' => 'Transcript Request'],
            ['office' => $registrar, 'name' => 'Enrollment Verification'],
            ['office' => $registrar, 'name' => 'Course Registration Issue'],
            ['office' => $registrar, 'name' => 'Graduation Clearance'],
            ['office' => $registrar, 'name' => 'Academic Record Correction'],

            // IT services
            ['office' => $it, 'name' => 'Student Portal Access Issue'],
            ['office' => $it, 'name' => 'Email Account Reset'],
            ['office' => $it, 'name' => 'Wi-Fi Access Issue'],
            ['office' => $it, 'name' => 'System Bug Report'],
            ['office' => $it, 'name' => 'ID Card System Issue'],

            // HOD services
            ['office' => $hod, 'name' => 'Course Add / Drop Approval'],
            ['office' => $hod, 'name' => 'Special Exam Approval'],
            ['office' => $hod, 'name' => 'Academic Appeal Review'],
            ['office' => $hod, 'name' => 'Departmental Clearance'],

            // Dean services
            ['office' => $dean, 'name' => 'Faculty Approval Request'],
            ['office' => $dean, 'name' => 'Academic Exception Approval'],
            ['office' => $dean, 'name' => 'Faculty Clearance'],
            ['office' => $dean, 'name' => 'Student Discipline Review'],

            // Student Affairs services
            ['office' => $studentAffairs, 'name' => 'Accommodation Request'],
            ['office' => $studentAffairs, 'name' => 'Counseling Appointment'],
            ['office' => $studentAffairs, 'name' => 'Student Welfare Issue'],
            ['office' => $studentAffairs, 'name' => 'Disciplinary Appeal'],

        ];

        foreach ($services as $service) {
            if (!$service['office']) {
                continue; // safety check
            }

            ServiceType::updateOrCreate(
                [
                    'office_id' => $service['office']->id,
                    'name' => $service['name'],
                ],
                []
            );
        }
    }
}
