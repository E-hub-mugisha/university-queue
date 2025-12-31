<!-- resources/views/admin/staff/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Staff Management</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#staffModal" onclick="resetForm()">Add Staff</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Faculty</th>
                <th>Position</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffs as $staff)
            <tr>
                <td>{{ $staff->user->name }}</td>
                <td>{{ $staff->user->email }}</td>
                <td>{{ $staff->department?->name }}</td>
                <td>{{ $staff->faculty?->name }}</td>
                <td>{{ $staff->position }}</td>
                <td>{{ $staff->phone }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#staffModal"
                        onclick="editStaff({{ $staff->id }}, '{{ $staff->user->name }}', '{{ $staff->user->email }}', '{{ $staff->department_id }}', '{{ $staff->faculty_id }}', '{{ $staff->position }}', '{{ $staff->phone }}')">Edit</button>

                    <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this staff?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Staff Modal -->
<div class="modal fade" id="staffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="staffForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" id="method" value="POST">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Department</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Faculty</label>
                        <select name="faculty_id" id="faculty_id" class="form-control">
                            <option value="">Select Faculty</option>
                            @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Position</label>
                        <input type="text" name="position" id="position" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('staffForm').action = "{{ route('admin.staff.store') }}";
        document.getElementById('method').value = 'POST';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('department_id').value = '';
        document.getElementById('faculty_id').value = '';
        document.getElementById('position').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
    }

    function editStaff(id, name, email, department_id, faculty_id, position, phone) {
        document.getElementById('staffForm').action = "/admin/staff/" + id;
        document.getElementById('method').value = 'PUT';
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('department_id').value = department_id;
        document.getElementById('faculty_id').value = faculty_id;
        document.getElementById('position').value = position;
        document.getElementById('phone').value = phone;
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').required = false;
    }
</script>
@endsection