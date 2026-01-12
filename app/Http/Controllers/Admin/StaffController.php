<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::with('user', 'office')->get();
        $offices = Office::all();
        return view('admin.staff.index', compact('staffs', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'office_id' => 'nullable|exists:offices,id',
            'position' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        // Create staff record
        Staff::create([
            'user_id' => $user->id,
            'office_id' => $request->office_id,
            'position' => $request->position,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Staff created successfully.');
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$staff->user_id}",
            'password' => 'nullable|string|min:6|confirmed',
            'office_id' => 'nullable|exists:offices,id',
            'position' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        // Update user
        $user = $staff->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update staff details
        $staff->update([
            'office_id' => $request->office_id,
            'position' => $request->position,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Staff updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->user->delete(); // Will also delete staff record due to cascade
        return redirect()->back()->with('success', 'Staff deleted successfully.');
    }
}
