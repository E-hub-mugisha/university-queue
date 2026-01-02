@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Requests</h5>
                    <h3>{{ $totalRequests }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>Pending Requests</h5>
                    <h3>{{ $pendingRequests }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Resolved Requests</h5>
                    <h3>{{ $resolvedRequests }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-secondary shadow">
                <div class="card-body">
                    <h5>Appointment Required</h5>
                    <h3>{{ $appointmentRequired }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    Requests by Department
                </div>
                <div class="card-body">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    Requests by Status
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Requests by Department
    const deptCtx = document.getElementById('departmentChart').getContext('2d');
    new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($requestsPerDepartment->pluck('name')) !!},
            datasets: [{
                label: '# of Requests',
                data: {!! json_encode($requestsPerDepartment->pluck('service_requests_count')) !!},
                backgroundColor: 'rgba(67, 94, 190, 0.7)',
                borderColor: 'rgba(67, 94, 190, 1)',
                borderWidth: 1
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // Requests by Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($requestsPerStatus->keys()) !!},
            datasets: [{
                data: {!! json_encode($requestsPerStatus->values()) !!},
                backgroundColor: [
                    'rgba(67, 94, 190, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(108, 117, 125, 0.7)',
                    'rgba(23, 162, 184, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {}
    });
</script>
@endsection
