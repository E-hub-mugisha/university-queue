<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\ServiceRequest;
use App\Models\Department;
use App\Models\Faculty;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Common stats
        $totalRequests = ServiceRequest::count();
        $pendingRequests = ServiceRequest::whereIn('status', ['Submitted', 'In Review', 'Awaiting Student Response'])->count();
        $resolvedRequests = ServiceRequest::where('status', 'Resolved')->count();
        $appointmentRequired = ServiceRequest::where('status', 'Appointment Required')->count();

        // Graph data - requests per department
        $requestsPerDepartment = Department::withCount('requests')->get();

        // Graph data - requests per status
        $requestsPerStatus = ServiceRequest::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'resolvedRequests',
            'appointmentRequired',
            'requestsPerDepartment',
            'requestsPerStatus'
        ));
    }
}
