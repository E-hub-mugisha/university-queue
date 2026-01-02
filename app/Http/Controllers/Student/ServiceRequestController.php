<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\RequestAttachment;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with('error', 'Student profile not found.');
        }

        $requests = ServiceRequest::with(['department', 'serviceType'])
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.requests.index', compact('requests'));
    }

    public function create()
    {
        $departments = Department::with('serviceTypes')->get();
        return view('student.requests.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'service_type_id' => 'required|exists:service_types,id',
            'description' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        $studentId = Auth::user()->student->id;

        $serviceRequest = ServiceRequest::create([
            'student_id' => $studentId,
            'department_id' => $request->department_id,
            'service_type_id' => $request->service_type_id,
            'description' => $request->description,
            'status' => 'Submitted',
            'priority' => $request->priority ?? 'normal',
            'queued_at' => now(),
        ]);

        // Upload files
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $file) {
                $path = $file->store('requests', 'public');

                RequestAttachment::create([
                    'service_request_id' => $serviceRequest->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName()
                ]);
            }
        }

        return back()->with('success', 'Request submitted successfully!');
    }
    public function show(ServiceRequest $request)
    {

        $request->load(['department', 'serviceType', 'attachments', 'replies']);

        return view('student.requests.show', compact('request'));
    }
}
