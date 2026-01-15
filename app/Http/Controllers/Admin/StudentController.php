<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user'])->get();
        $users = User::where('role', 'student')->get();
        $offices = Office::all();

        return view('admin.students.index', compact('students', 'users', 'offices'));
    }

    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'program'  => 'nullable|string|max:255',
            'level'    => 'nullable|string|max:50',
            'phone'    => 'nullable|string|max:20',
        ]);

        // 1️⃣ Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student', // ensure student role
        ]);

        // 2️⃣ Create Student linked to user
        $student = Student::create([
            'user_id'        => $user->id,
            'program'        => $request->program,
            'level'          => $request->level,
            'phone'          => $request->phone,
            // student_number is auto-generated in Student model
        ]);

        return redirect()->back()->with('success', 'Student created successfully.');
    }

    // Update existing student
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $student->user_id,
            'password' => 'nullable|string|min:6|confirmed',
            'program'  => 'nullable|string|max:255',
            'level'    => 'nullable|string|max:50',
            'phone'    => 'nullable|string|max:20',
        ]);

        // Update User
        $userData = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $student->user->update($userData);

        // Update Student
        $student->update([
            'program' => $request->program,
            'level'   => $request->level,
            'phone'   => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Student updated successfully.');
    }

    // Destroy student
    public function destroy(Student $student)
    {
        // Optional: delete linked user
        $student->user->delete();
        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully.');
    }
}
