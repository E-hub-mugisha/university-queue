@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Service Request</h3>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('student.request.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>department</label>
            <select name="department_id" id="department" class="form-control" required>
                <option value="">Select department</option>
                @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Service Type</label>
            <select name="service_type_id" id="service_type" class="form-control" required>
                <option value="">Select Service Type</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Description (Optional)</label>
            <textarea class="form-control" name="description" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label>Attachments (Optional)</label>
            <input type="file" name="attachments[]" class="form-control" multiple>
            <small>PDF, Images, Docs | Max 5MB each</small>
        </div>

        <button class="btn btn-primary">Submit Request</button>
    </form>
</div>

<script>
    document.getElementById('department').addEventListener('change', function() {
        let departmentId = this.value;
        let serviceSelect = document.getElementById('service_type');
        serviceSelect.innerHTML = '<option value="">Loading...</option>';

        fetch('/api/service-types/' + departmentId)
            .then(res => res.json())
            .then(data => {
                serviceSelect.innerHTML = '<option value="">Select Service Type</option>';
                data.forEach(type => {
                    serviceSelect.innerHTML += `<option value="${type.id}">${type.name}</option>`;
                });
            });
    });
</script>

@endsection