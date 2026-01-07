@extends('layouts.app')
@section('title', 'Service Requests')
@section('content')
<div class="container mt-4">

    <h3 class="mb-4">All Student Service Requests</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Submitted" {{ request('status')=='Submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="In Review" {{ request('status')=='In Review' ? 'selected' : '' }}>In Review</option>
                        <option value="Resolved" {{ request('status')=='Resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Request No</th>
                        <th>Student</th>
                        <th>Department</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Waiting Time</th>
                        <th>Submitted On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $index => $req)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $req->request_number }}</td>
                        <td>{{ $req->student->user->name ?? 'N/A' }}</td>
                        <td>{{ $req->department->name ?? 'N/A' }}</td>
                        <td>{{ $req->serviceType->name ?? 'N/A' }}</td>
                        <td>
                            @php
                            $badge = match($req->status){
                            'Submitted' => 'primary',
                            'In Review' => 'warning',
                            'Awaiting Student Response' => 'info',
                            'Appointment Required' => 'secondary',
                            'Resolved' => 'success',
                            'Closed' => 'dark',
                            default => 'secondary'
                            };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $req->status }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $req->priority === 'urgent' ? 'danger' : 'secondary' }}">
                                {{ ucfirst($req->priority) }}
                            </span>
                        </td>
                        <td>{{ $req->waiting_time }}</td>
                        <td>{{ $req->created_at->format('d M Y h:i A') }}</td>
                        <td>
                            <a href="{{ route('staff.requests.show', $req->id) }}" class="btn btn-sm btn-outline-dark">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No service requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                
            </div>
        </div>
    </div>

</div>
@endsection