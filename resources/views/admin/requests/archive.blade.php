@extends('layouts.app')

@section('title', 'Archived Requests')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h4>Archived Requests</h4>
        <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-primary">
            Active Requests
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Request ID</th>
                        <th>Student</th>
                        <th>Office</th>
                        <th>Status</th>
                        <th>Archived At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $req->request_number }}</td>
                            <td>{{ $req->student->user->name }}</td>
                            <td>{{ $req->office->name }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $req->status }}</span>
                            </td>
                            <td>{{ $req->archived_at?->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.requests.show', $req) }}"
                                   class="btn btn-sm btn-outline-info">
                                    View
                                </a>

                                {{-- Optional restore --}}
                                <form method="POST"
                                      action="{{ route('admin.requests.restore', $req) }}"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-success">
                                        Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                            No archived requests
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
