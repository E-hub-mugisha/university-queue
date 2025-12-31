@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Students</h3>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#studentModal" onclick="resetForm()">Add Student</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student No</th>
                <th>User</th>
                <th>Faculty</th>
                <th>Department</th>
                <th>Program</th>
                <th>Level</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($students as $s)
            <tr>
                <td>{{ $s->student_number }}</td>
                <td>{{ $s->user->name }}</td>
                <td>{{ $s->faculty->name ?? 'N/A' }}</td>
                <td>{{ $s->department->name ?? 'N/A' }}</td>
                <td>{{ $s->program }}</td>
                <td>{{ $s->level }}</td>
                <td>{{ $s->phone }}</td>
                <td>
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#studentModal"
                        onclick="editStudent({{ $s->id }}, '{{ $s->department_id }}', '{{ $s->faculty_id }}', '{{ $s->program }}', '{{ $s->level }}', '{{ $s->phone }}')">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('admin.students.destroy',$s) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete student?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Student Modal -->
<div class="modal fade" id="studentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="studentForm" method="POST">
                @csrf
                <input type="hidden" id="method" name="_method" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Student Form</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>User</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Select Student User</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Faculty</label>
                        <select name="faculty_id" id="faculty_id" class="form-control">
                            <option value="">Select Faculty</option>
                            @foreach($faculties as $f)
                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Department</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input class="form-control mb-2" name="program" id="program" placeholder="Program">
                    <input class="form-control mb-2" name="level" id="level" placeholder="Level">
                    <input class="form-control mb-2" name="phone" id="phone" placeholder="Phone">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save Student</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('studentForm').action = "{{ route('admin.students.store') }}";
        document.getElementById('method').value = "POST";
    }

    function editStudent(id, department_id, faculty_id, program, level, phone) {
        document.getElementById('studentForm').action = "/admin/students/" + id;
        document.getElementById('method').value = "PUT";

        document.getElementById('department_id').value = department_id;
        document.getElementById('faculty_id').value = faculty_id;
        document.getElementById('program').value = program;
        document.getElementById('level').value = level;
        document.getElementById('phone').value = phone;
    }
</script>

@endsection