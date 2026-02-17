@extends('layouts.app')
@section('title', 'Create Service Request')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Create Service Request</h3>
                <a href="{{ route('student.requests.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Requests
                </a>
            </div>

            {{-- Success Toast --}}
            @if(session('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            @endif

            {{-- Request Form Card --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('student.requests.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Office Selection --}}
                        <div class="mb-3">
                            <label class="form-label">Office</label>

                            <select id="office"
                                name="office_id"
                                class="form-select"
                                {{ request()->has('office_id') ? 'readonly' : '' }}
                                required>
                                <option value="">Select Office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}"
                                        {{ old('office_id', request('office_id')) == $office->id ? 'selected' : '' }}>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('office_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Service Type --}}
                        <div class="mb-3">
                            <label class="form-label">Service Type</label>
                            <select name="service_type_id" id="service_type" class="form-select" required>
                                <option value="">Select Service Type</option>
                            </select>
                            @error('service_type_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Attachments --}}
                        <div class="mb-3">
                            <label class="form-label">Attachments (Optional)</label>
                            <input type="file" name="attachments[]" class="form-control" multiple>
                            <small class="text-muted">PDF, Images, Docs | Max 5MB each</small>
                            @error('attachments.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send"></i> Submit Request
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    const officeSelect = document.getElementById('office');
    const serviceSelect = document.getElementById('service_type');

    // Determine initial office (from query string or selected value)
    let selectedOffice = officeSelect.value || "{{ request('office_id') }}";

    // Fetch service types
    function fetchServiceTypes(officeId, selectedService = null) {
        if (!officeId) return;

        serviceSelect.innerHTML = '<option value="">Loading...</option>';
        serviceSelect.disabled = true;

        fetch(`/api/service-types/${officeId}`)
            .then(res => res.json())
            .then(data => {
                serviceSelect.innerHTML = '<option value="">Select Service Type</option>';
                data.forEach(type => {
                    const selected = selectedService == type.id ? 'selected' : '';
                    serviceSelect.innerHTML += `<option value="${type.id}" ${selected}>${type.name}</option>`;
                });
                serviceSelect.disabled = false;
            })
            .catch(() => {
                serviceSelect.innerHTML = '<option value="">Select Service Type</option>';
                serviceSelect.disabled = false;
            });
    }

    // Initial fetch if office preselected
    if (selectedOffice) {
        fetchServiceTypes(selectedOffice, "{{ old('service_type_id') }}");
    }

    // Fetch on office change
    officeSelect.addEventListener('change', function() {
        fetchServiceTypes(this.value);
    });

});
</script>
@endsection
