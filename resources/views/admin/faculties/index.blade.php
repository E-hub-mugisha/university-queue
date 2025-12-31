<!-- resources/views/admin/faculties/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Faculties</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#facultyModal" onclick="resetForm()">Add Faculty</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faculties as $faculty)
            <tr>
                <td>{{ $faculty->name }}</td>
                <td>{{ $faculty->department->name }}</td>
                <td>{{ $faculty->description }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#facultyModal"
                        onclick="editFaculty({{ $faculty->id }}, '{{ $faculty->name }}', '{{ $faculty->department_id }}', '{{ $faculty->description }}')">Edit</button>

                    <form action="{{ route('admin.faculties.destroy', $faculty) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this faculty?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Faculty Modal -->
<div class="modal fade" id="facultyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="facultyForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Faculty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" id="method" value="POST">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Department</label>
                        <select name="department_id" id="department_id" class="form-control" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save Faculty</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('facultyForm').action = "{{ route('admin.faculties.store') }}";
        document.getElementById('method').value = 'POST';
        document.getElementById('name').value = '';
        document.getElementById('department_id').value = '';
        document.getElementById('description').value = '';
    }

    function editFaculty(id, name, department_id, description) {
        document.getElementById('facultyForm').action = "/admin/faculties/" + id;
        document.getElementById('method').value = 'PUT';
        document.getElementById('name').value = name;
        document.getElementById('department_id').value = department_id;
        document.getElementById('description').value = description;
    }
</script>
@endsection