@extends('layouts.app')
@section('title', 'Request Detail: ' . $request->request_number)
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <div class="nk-block nk-block-lg">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold">
                        <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                        Request Detail: {{ $request->request_number }}
                    </h3>
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Student Info -->
                <div class="card mb-3 shadow-sm rounded-4 p-4">
                    <div class="card-body d-flex align-items-center gap-3 p-4">
                        <img src="{{ $request->student->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($request->student->user->name) . '&background=0D6EFD&color=fff' }}"
                            class="rounded-circle" width="60" height="60" alt="Student Avatar">
                        <div>
                            <h6 class="fw-semibold mb-1">{{ $request->student->user->name ?? 'N/A' }}</h6>
                            <p class="mb-0 text-muted">{{ $request->student->user->email ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Office:</strong> {{ $request->office->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Request Details -->
                @php
                $statusClass = match ($request->status) {
                'Submitted' => 'primary',
                'In Review' => 'warning',
                'Awaiting Student Response' => 'info',
                'Appointment Required' => 'secondary',
                'Resolved' => 'success',
                'Closed' => 'dark',
                default => 'secondary',
                };
                @endphp

                <div class="card mb-3 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="fw-semibold">Request Details</h5>
                        <p><strong>Service Type:</strong> {{ $request->serviceType->name ?? 'N/A' }}</p>
                        <p><strong>Description:</strong> {{ $request->description }}</p>
                        @if($request->attachment)
                        <p><strong>Attachment:</strong>
                            <a href="{{ asset('storage/'.$request->attachment) }}" target="_blank">View</a>
                        </p>
                        @endif
                        <p>
                            <strong>Status:</strong>
                            <span class="badge bg-{{ $statusClass }}">{{ $request->status }}</span>
                        </p>
                    </div>
                </div>

                <!-- Replies -->
                <div class="card mb-3 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Replies</h5>
                        @forelse($request->replies as $reply)
                        <div class="border rounded p-3 mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">{{ $reply->user->name }} | {{ $reply->created_at->format('d M Y h:i A') }}</small>
                            </div>
                            <p class="mb-1">{{ $reply->message }}</p>
                            @if($reply->attachment)
                            <p class="mb-0"><strong>Attachment:</strong>
                                <a href="{{ asset('storage/'.$reply->attachment) }}" target="_blank">View</a>
                            </p>
                            @endif
                        </div>
                        @empty
                        <p class="text-muted">No replies yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Buttons for modals -->
                <div class="d-flex gap-2 mb-4">

                    <button class="btn btn-primary p-3 mb-3" data-bs-toggle="modal" data-bs-target="#replyModal">
                        <i class="bi bi-reply me-1"></i> Send Reply / Update Status
                    </button>
                </div>

                <!-- Status Timeline -->
                <div class="card mb-3 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Status Timeline</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="bi bi-check-circle text-primary me-2"></i>
                                Submitted – {{ $request->created_at->format('d M Y h:i A') }}
                            </li>
                            @foreach($request->replies as $reply)
                            <li class="list-group-item">
                                <i class="bi bi-chat-left-text text-info me-2"></i>
                                {{ $reply->user->name }} replied – {{ $reply->created_at->format('d M Y h:i A') }}
                            </li>
                            @endforeach
                            @if($request->appointment)
                            <li class="list-group-item">
                                <i class="bi bi-calendar-event text-success me-2"></i>
                                Appointment Scheduled: {{ $request->appointment->appointment_date }} at {{ $request->appointment->appointment_time }}
                            </li>
                            @endif
                            @if($request->status === 'Resolved')
                            <li class="list-group-item">
                                <i class="bi bi-flag-fill text-success me-2"></i>
                                Request Resolved
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-primary bg-opacity-10 border-0 rounded-top-4">
                <h5 class="modal-title fw-semibold">
                    <i class="bi bi-reply me-2"></i> Send Reply / Update Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('student.requests.reply', $request->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="4" placeholder="Type your message..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="attachment" class="form-control">
                    </div>
                    <div class="mb-3">
                        <select name="status" class="form-select" required>
                            @foreach(['Submitted','In Review','Resolved','Closed'] as $status)
                            <option value="{{ $status }}" {{ $request->status==$status?'selected':'' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection