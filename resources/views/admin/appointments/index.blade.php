@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="container">

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-calendar3"></i> Appointments
            </h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Request</th>
                        <th>Student</th>
                        <th>Staff</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($appointments as $index => $appointment)
                    <tr>
                        <td>{{ $index + 1 + ($appointments->currentPage()-1)*$appointments->perPage() }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $appointment->serviceRequest->request_number }}
                            </span>
                        </td>

                        <td>{{ $appointment->serviceRequest->student->user->name }}</td>
                        <td>{{ $appointment->staff->user->name }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->staff->department->name ?? 'N/A' }}</td>

                        <td>
                            <a href="{{ route('admin.appointments.show', $appointment) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>

                            <button class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#cancelModal{{ $appointment->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Cancel Modal --}}
                    <div class="modal fade" id="cancelModal{{ $appointment->id }}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Cancel Appointment</h5>
                                </div>

                                <div class="modal-body">
                                    Are you sure you want to cancel this appointment?
                                </div>

                                <div class="modal-footer">
                                    <form method="POST"
                                        action="{{ route('admin.appointments.cancel', $appointment) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <button class="btn btn-danger">Yes, Cancel</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No appointments found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $appointments->links() }}
        </div>
    </div>

</div>
@endsection