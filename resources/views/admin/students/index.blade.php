@extends('layouts.app')
@section('title', 'Students')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="nk-block-title">Students</h4>
                            <div class="d-flex gap-2">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <button class="btn btn-primary mb-3 p-3" data-bs-toggle="modal" data-bs-target="#studentModal" onclick="resetForm()">Add Student</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">Student No</th>
                                    <th class="nk-tb-col">Name</th>
                                    <th class="nk-tb-col">Email</th>
                                    <th class="nk-tb-col">Program</th>
                                    <th class="nk-tb-col">Level</th>
                                    <th class="nk-tb-col">Phone</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($students as $s)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col">{{ $s->student_number }}</td>
                                    <td class="nk-tb-col">{{ $s->user->name }}</td>
                                    <td class="nk-tb-col">{{ $s->user->email }}</td>
                                    <td class="nk-tb-col">{{ $s->program }}</td>
                                    <td class="nk-tb-col">{{ $s->level }}</td>
                                    <td class="nk-tb-col">{{ $s->phone }}</td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a role="button" class="text-warning" data-bs-toggle="modal" data-bs-target="#studentModal"
                                                                    onclick="editStudent({{ $s->id }}, '{{ $s->user->name }}', '{{ $s->user->email }}', '{{ $s->program }}', '{{ $s->level }}', '{{ $s->phone }}')">Edit</a>
                                                            </li>
                                                            <li>
                                                                <a role="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $s->id }}">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@foreach($students as $s)
<div class="modal fade" id="deleteModal{{ $s->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.students.destroy',$s) }}" class="d-inline">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this student?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


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
                        <label>Full Name</label>
                        <input class="form-control" name="name" id="name" placeholder="Full Name" required>
                    </div>

                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                    </div>

                    <div class="mb-2">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    </div>

                    <div class="mb-2">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                    </div>

                    <div class="mb-2">
                        <label>Program</label>
                        <input class="form-control" name="program" id="program" placeholder="Program">
                    </div>

                    <div class="mb-2">
                        <label>Level</label>
                        <input class="form-control" name="level" id="level" placeholder="Level">
                    </div>

                    <div class="mb-2">
                        <label>Phone</label>
                        <input class="form-control" name="phone" id="phone" placeholder="Phone">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
function resetForm() {
    document.getElementById('studentForm').action = "{{ route('admin.students.store') }}";
    document.getElementById('method').value = "POST";

    // Clear all fields
    document.getElementById('name').value = "";
    document.getElementById('email').value = "";
    document.getElementById('password').value = "";
    document.getElementById('password_confirmation').value = "";
    document.getElementById('program').value = "";
    document.getElementById('level').value = "";
    document.getElementById('phone').value = "";
}

function editStudent(id, name, email, program, level, phone) {
    document.getElementById('studentForm').action = "/admin/students/" + id;
    document.getElementById('method').value = "PUT";

    // Populate fields
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('password').value = "";
    document.getElementById('password_confirmation').value = "";
    document.getElementById('program').value = program;
    document.getElementById('level').value = level;
    document.getElementById('phone').value = phone;

    // Password is optional during edit
    document.getElementById('password').removeAttribute('required');
    document.getElementById('password_confirmation').removeAttribute('required');
}
</script>


@endsection
