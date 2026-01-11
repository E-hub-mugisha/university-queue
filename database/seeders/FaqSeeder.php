<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How do I pay tuition fees?',
                'answer' => 'Tuition fees can be paid online via the student portal or at the finance office.',
                'department_id' => 1, // Finance
                'is_active' => true,
            ],
            [
                'question' => 'How can I get a payment receipt?',
                'answer' => 'Receipts are generated automatically after payment and can be downloaded from your dashboard.',
                'department_id' => 1, // Finance
                'is_active' => true,
            ],
            [
                'question' => 'How do I request an academic transcript?',
                'answer' => 'Transcript requests can be submitted online through the Registrar section.',
                'department_id' => 2, // Registrar
                'is_active' => true,
            ],
            [
                'question' => 'My student portal is not working, what should I do?',
                'answer' => 'Submit an IT support request and attach screenshots if possible.',
                'department_id' => 3, // IT Support
                'is_active' => true,
            ],
            [
                'question' => 'When is a physical visit required?',
                'answer' => 'A physical visit is only required when an appointment is scheduled by staff.',
                'department_id' => null, // General FAQ
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            DB::table('faqs')->insert(array_merge($faq, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
