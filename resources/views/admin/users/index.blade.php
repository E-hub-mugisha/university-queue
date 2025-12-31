<!-- resources/views/admin/users/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Management</h2>

    <!-- Success message -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add User Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">Add User</button>

    <!-- Users Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userModal"
                        onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">Edit</button>

                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="userForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit User</h5>
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
                        <label>Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="student">Student</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function resetForm() {
        document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
        document.getElementById('method').value = 'POST';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role').value = 'student';
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
    }

    function editUser(id, name, email, role) {
        document.getElementById('userForm').action = "/admin/users/" + id;
        document.getElementById('method').value = 'PUT';
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('role').value = role;
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').required = false;
    }
</script>
@endsection