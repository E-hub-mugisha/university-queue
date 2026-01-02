<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'location' => 'nullable|string'
        ]);

        $exists = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('location', $request->location)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'appointment_time' => 'This time slot is already booked. Please choose another time.'
            ]);
        }

        $serviceRequest->appointment()->create($request->all());

        return back()->with('success', 'Appointment scheduled successfully.');
    }
}
