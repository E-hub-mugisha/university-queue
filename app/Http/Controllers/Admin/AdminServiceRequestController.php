<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RequestRepliedMail;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        // Optional: filter by status or office
        $query = ServiceRequest::with(['student.user', 'office', 'serviceType']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('office_id')) {
            $query->where('office_id', $request->office_id);
        }

        $requests = $query->latest()->paginate(15);

        return view('admin.requests.index', compact('requests'));
    }

    // Show request detail
    public function show(ServiceRequest $request)
    {
        $request->load(['student.user', 'office', 'serviceType', 'replies']);
        return view('admin.requests.show', compact('request'));
    }

    // Reply to request
    public function reply(Request $r, ServiceRequest $request)
    {
        $r->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'status' => 'required|in:Submitted,In Review,Awaiting Student Response,Appointment Required,Appointment Scheduled,Resolved,Closed'
        ]);

        $filePath = null;
        if ($r->hasFile('attachment')) {
            $filePath = $r->file('attachment')->store('request_replies', 'public');
        }

        // Save reply
        $reply = new ServiceRequestReply();
        $reply->service_request_id = $request->id;
        $reply->user_id = auth()->id();
        $reply->message = $r->message;
        $reply->attachment = $filePath;
        $reply->save();

        // Update request status
        $request->status = $r->status;
        $request->save();

        Mail::to($request->student->user->email)
            ->send(new RequestRepliedMail($request));

        return back()->with('success', 'Reply sent successfully.');
    }
}
