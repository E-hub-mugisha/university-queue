@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="container">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-calendar-check"></i>
                Appointment Details
            </h5>
        </div>

        <div class="card-body">

            <h6 class="text-primary">Appointment Information</h6>
            <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
            <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
            <p><strong>Location:</strong> {{ $appointment->location ?? 'N/A' }}</p>

            <hr>

            <h6 class="text-primary">Request Information</h6>
            <p><strong>Request ID:</strong> {{ $appointment->serviceRequest->request_number }}</p>
            <p><strong>Status:</strong> {{ $appointment->serviceRequest->status }}</p>

            <hr>

            <h6 class="text-primary">Student</h6>
            <p><strong>Name:</strong> {{ $appointment->serviceRequest->student->user->name }}</p>
            <p><strong>Email:</strong> {{ $appointment->serviceRequest->student->user->email }}</p>

            <hr>

            <h6 class="text-primary">Staff</h6>
            <p><strong>Name:</strong> {{ $appointment->staff->user->name }}</p>
            <p><strong>Department:</strong> {{ $appointment->staff->department->name ?? 'N/A' }}</p>

            <div class="mt-4">
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

        </div>
    </div>

</div>
@endsection