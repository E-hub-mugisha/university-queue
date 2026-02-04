<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if ($user->student && $user->student->isProfileComplete()) {
            return redirect()->route('dashboard');
        }

        return view(
            'student.complete-profile',
            ['student' => $user->student]
        );
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'program' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
        ]);

        $student = \App\Models\Student::where('user_id', $id)->firstOrFail();
        $student->update(
            $request->only('program', 'phone')
        );

        return redirect()->route('dashboard')
            ->with('success', 'Profile completed successfully.');
    }

    public function faq()
    {
        return view('student.faq.index');
    }
}
