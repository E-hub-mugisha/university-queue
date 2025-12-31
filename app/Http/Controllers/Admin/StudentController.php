<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user','department','faculty'])->get();
        $users = User::where('role', 'student')->get();
        $departments = Department::all();
        $faculties = Faculty::all();

        return view('admin.students.index', compact('students', 'users', 'departments', 'faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:students,user_id',
            'department_id' => 'nullable|exists:departments,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'program' => 'nullable|string',
            'level' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        Student::create($request->all());

        return back()->with('success', 'Student created successfully.');
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'program' => 'nullable|string',
            'level' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $student->update($request->all());

        return back()->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Student deleted successfully.');
    }
}
