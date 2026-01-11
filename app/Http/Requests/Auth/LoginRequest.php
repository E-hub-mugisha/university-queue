<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Student;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $loginInput = $this->input('login');
        $password = $this->input('password');

        $user = null;

        // 1️⃣ Check if login input matches email in users table
        $user = \App\Models\User::where('email', $loginInput)->first();

        // 2️⃣ If not, check if login input matches student_number in students table
        if (!$user) {
            $student = Student::where('student_number', $loginInput)->first();
            if ($student && $student->user) {
                $user = $student->user;
            }
        }

        // 3️⃣ Validate user & password
        if (!$user || !Hash::check($password, $user->password)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        // 4️⃣ Login user
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return strtolower($this->input('login')).'|'.$this->ip();
    }
}
