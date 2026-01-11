@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold">My Service Requests</h4>

        <a href="{{ route('student.requests.create') }}" class="btn btn-primary">
            + New Request
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Request No</th>
                        <th>Office / Department</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Submitted On</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($requests as $index => $req)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td class="fw-bold">
                            {{ $req->request_number }}
                        </td>

                        <td>
                            {{ $req->department?->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $req->serviceType?->name ?? 'N/A' }}
                        </td>

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

                            <span class="badge bg-{{ $badge }}">
                                {{ $req->status }}
                            </span>
                        </td>

                        <td>{{ $req->created_at->format('d M Y h:i A') }}</td>

                        <td>
                            <a href="{{ route('student.requests.show',$req->id) }}"
                               class="btn btn-sm btn-outline-dark">
                                View
                            </a>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            No service requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $requests->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
