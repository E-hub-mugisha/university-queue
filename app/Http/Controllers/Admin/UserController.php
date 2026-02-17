<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $offices = Office::all();
        return view('admin.users.index', compact('users', 'offices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:student,staff,admin',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validated['role'] === 'student') {
            $request->validate([
                'student_number' => [
                    'required',
                    'string',
                    'unique:students,student_number',
                    'regex:/^\d{5}\/\d{4}$/',
                    function ($attribute, $value, $fail) {
                        $year = (int) explode('/', $value)[1];
                        $currentYear = (int) now()->format('Y');

                        if ($year < 1900 || $year > $currentYear) {
                            $fail('The student number year must be a valid 4-digit year and cannot be in the future.');
                        }
                    },
                ],
                'faculty' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'campus' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);
        }

        if ($validated['role'] === 'staff') {
            $request->validate([
                'office_id' => 'nullable|exists:offices,id',
                'position' => 'nullable|string|max:255',
                'campus' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'faculty' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($validated['role'] === 'student') {
            Student::create([
                'user_id' => $user->id,
                'student_number' => $request->student_number,
                'faculty' => $request->faculty,
                'department' => $request->department,
                // Keep aligned for legacy code paths.
                'program' => $request->department,
                'campus' => $request->campus,
                'phone' => $request->phone,
            ]);
        }

        if ($validated['role'] === 'staff') {
            $office = $request->filled('office_id') ? Office::find($request->office_id) : null;
            $isStudentAffairs = $office && str_contains(strtolower($office->name), 'student affairs');

            if ($isStudentAffairs) {
                $request->validate([
                    'faculty' => 'required|string|max:255',
                    'department' => 'required|string|max:255',
                ]);
            }

            Staff::create([
                'user_id' => $user->id,
                'office_id' => $request->office_id,
                'position' => $request->position,
                'campus' => $request->campus,
                'phone' => $request->phone,
                'faculty' => $isStudentAffairs ? $request->faculty : null,
                'department' => $isStudentAffairs ? $request->department : null,
            ]);
        }

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'required|in:student,staff,admin',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return back()->with('success', 'User status updated successfully.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10);

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Optional: email the new password
        Mail::raw(
            "Your password has been reset.\nNew Password: $newPassword",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Password Reset');
            }
        );

        return back()->with('success', 'Password reset successfully.');
    }

    public function verify(User $user)
    {
        $user->update([
            'email_verified_at' => now(),
        ]);

        return back()->with('success', 'User verified successfully.');
    }
}
