@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Request Detail: {{ $request->request_number }}</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <h5>Student Info</h5>
            <p><strong>Name:</strong> {{ $request->student->user->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $request->student->user->email ?? 'N/A' }}</p>
            <p><strong>Department:</strong> {{ $request->department->name ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5>Request Details</h5>
            <p><strong>Service Type:</strong> {{ $request->serviceType->name ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $request->description }}</p>
            @if($request->attachment)
            <p><strong>Attachment:</strong>
                <a href="{{ asset('storage/'.$request->attachment) }}" target="_blank">View</a>
            </p>
            @endif
            <p><strong>Status:</strong>
                <span class="badge bg-{{ match($request->status) {
                    'Submitted'=>'primary',
                    'In Review'=>'warning',
                    'Awaiting Student Response'=>'info',
                    'Appointment Required'=>'secondary',
                    'Resolved'=>'success',
                    'Closed'=>'dark',
                    default=>'secondary'
                }}}">{{ $request->status }}</span>
            </p>
        </div>
    </div>

    <!-- Replies -->
    <div class="card mb-3">
        <div class="card-body">
            <h5>Replies</h5>
            @forelse($request->replies as $reply)
            <div class="border rounded p-2 mb-2">
                <small class="text-muted">{{ $reply->user->name }} | {{ $reply->created_at->format('d M Y h:i A') }}</small>
                <p>{{ $reply->message }}</p>
                @if($reply->attachment)
                <p>Attachment: <a href="{{ asset('storage/'.$reply->attachment) }}" target="_blank">View</a></p>
                @endif
            </div>
            @empty
            <p class="text-muted">No replies yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Reply Form -->
    <div class="card">
        <div class="card-body">
            <h5>Send Reply / Update Status</h5>
            <form action="{{ route('admin.requests.reply', $request->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="attachment" class="form-label">Attachment (optional)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Submitted" {{ $request->status=='Submitted'?'selected':'' }}>Submitted</option>
                        <option value="In Review" {{ $request->status=='In Review'?'selected':'' }}>In Review</option>
                        <option value="Awaiting Student Response" {{ $request->status=='Awaiting Student Response'?'selected':'' }}>Awaiting Student Response</option>
                        <option value="Appointment Required" {{ $request->status=='Appointment Required'?'selected':'' }}>Appointment Required</option>
                        <option value="Resolved" {{ $request->status=='Resolved'?'selected':'' }}>Resolved</option>
                        <option value="Closed" {{ $request->status=='Closed'?'selected':'' }}>Closed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Send Reply</button>
            </form>
        </div>
    </div>

</div>
@endsection