<!-- resources/views/admin/departments/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Departments</h2>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Department Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#departmentModal" onclick="resetForm()">Add Department</button>

    <!-- Departments Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#departmentModal"
                        onclick="editDepartment({{ $department->id }}, '{{ $department->name }}', '{{ $department->description }}')">Edit</button>

                    <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this department?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Department Modal -->
<div class="modal fade" id="departmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="departmentForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" id="method" value="POST">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('departmentForm').action = "{{ route('admin.departments.store') }}";
        document.getElementById('method').value = 'POST';
        document.getElementById('name').value = '';
        document.getElementById('description').value = '';
    }

    function editDepartment(id, name, description) {
        document.getElementById('departmentForm').action = "/admin/departments/" + id;
        document.getElementById('method').value = 'PUT';
        document.getElementById('name').value = name;
        document.getElementById('description').value = description;
    }
</script>
@endsection