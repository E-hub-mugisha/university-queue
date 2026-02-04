@extends('layouts.app')
@section('title', 'Complete Profile')
@section('content')

@php
$student = auth()->user()->student;
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Complete Student Profile</h5>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        Please provide the missing information to continue.
                    </p>

                    <form method="POST" action="{{ route('student.profile.update', $student->user_id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Program</label>
                            <input type="text" name="program"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                class="form-control"
                                required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Save & Continue
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection