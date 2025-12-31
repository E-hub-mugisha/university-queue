<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::with('department')->get();
        $departments = Department::all();
        return view('admin.faculties.index', compact('faculties', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:faculties,name',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        Faculty::create($request->only('name', 'department_id', 'description'));

        return redirect()->back()->with('success', 'Faculty created successfully.');
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|unique:faculties,name,' . $faculty->id,
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ]);

        $faculty->update($request->only('name', 'department_id', 'description'));

        return redirect()->back()->with('success', 'Faculty updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->back()->with('success', 'Faculty deleted successfully.');
    }
}
