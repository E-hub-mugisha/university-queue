<?php

use App\Http\Controllers\Admin\AdminServiceRequestController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Student\ServiceRequestController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/api/service-types/{department}', function ($departmentId) {
    return \App\Models\ServiceType::where('department_id', $departmentId)->get();
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Student routes
    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'dashboard']);

        Route::prefix('student')->name('student.')->group(function () {
            Route::get('requests', [ServiceRequestController::class, 'index'])->name('requests.index');
            Route::get('requests/create', [ServiceRequestController::class, 'create'])->name('requests.create');
            Route::post('requests', [ServiceRequestController::class, 'store'])->name('requests.store');
            Route::get('requests/{request}', [ServiceRequestController::class, 'show'])->name('requests.show');
        });
    });

    // Staff routes
    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', [StaffDashboardController::class, 'dashboard']);
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'dashboard']);

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::post('users', [UserController::class, 'store'])->name('users.store');
            Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
            Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
            Route::put('departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
            Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('faculties', [FacultyController::class, 'index'])->name('faculties.index');
            Route::post('faculties', [FacultyController::class, 'store'])->name('faculties.store');
            Route::put('faculties/{faculty}', [FacultyController::class, 'update'])->name('faculties.update');
            Route::delete('faculties/{faculty}', [FacultyController::class, 'destroy'])->name('faculties.destroy');
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
            Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
            Route::put('staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
            Route::delete('staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('students', [StudentController::class, 'index'])->name('students.index');
            Route::post('students', [StudentController::class, 'store'])->name('students.store');
            Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
            Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        });

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('requests', [AdminServiceRequestController::class, 'index'])->name('requests.index');
            Route::get('requests/create', [AdminServiceRequestController::class, 'create'])->name('requests.create');
            Route::post('requests', [AdminServiceRequestController::class, 'store'])->name('requests.store');
            Route::get('requests/{request}', [AdminServiceRequestController::class, 'show'])->name('requests.show');
            Route::put('requests/{request}', [AdminServiceRequestController::class, 'update'])->name('requests.update');
            Route::delete('requests/{request}', [AdminServiceRequestController::class, 'destroy'])->name('requests.destroy');
            Route::post('requests/{request}/reply', [AdminServiceRequestController::class, 'reply'])->name('requests.reply');

            Route::post('requests/{serviceRequest}/appointment', [AppointmentController::class, 'store'])->name('appointments.store');
        });
    });
});

require __DIR__ . '/auth.php';
