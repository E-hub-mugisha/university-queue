@extends('layouts.app')
@section('title', 'Complete Profile')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Complete Student Profile</h5>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        Please provide the missing information to continue.
                    </p>

                    <form method="POST" action="{{ route('student.profile.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Program</label>
                            <input type="text" name="program"
                                   class="form-control"
                                   value="{{ old('program', $student->program) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select name="level" class="form-select" required>
                                <option value="">Select level</option>
                                @foreach (['Year 1','Year 2','Year 3'] as $level)
                                    <option value="{{ $level }}"
                                        @selected(old('level', $student->level) === $level)>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                   class="form-control"
                                   value="{{ old('phone', $student->phone) }}"
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
