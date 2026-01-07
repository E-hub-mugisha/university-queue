@extends('layouts.app')
@section('title', 'User Management')
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
                <th>Status</th>
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
                    @if(!$user->is_active)
                    <span class="badge bg-danger">Disabled</span>
                    @else
                    <span class="badge bg-success">Active</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#userModal"
                        onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">Edit</button>
                    <!-- Disable / Enable -->
                    <button class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}"
                        data-bs-toggle="modal"
                        data-bs-target="#statusModal{{ $user->id }}">
                        <i class="bi {{ $user->is_active ? 'bi-person-x' : 'bi-person-check' }}"></i>
                        {{ $user->is_active ? 'Disable' : 'Enable' }}
                    </button>

                    <!-- Reset Password -->
                    <button class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#resetModal{{ $user->id }}">
                        <i class="bi bi-key"></i>Rest Password
                    </button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">Delete</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($users as $user)
<div class="modal fade" id="statusModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $user->is_active ? 'Disable' : 'Enable' }} User
                </h5>
            </div>

            <div class="modal-body">
                Are you sure you want to
                <strong>{{ $user->is_active ? 'disable' : 'enable' }}</strong>
                {{ $user->name }}?
            </div>

            <div class="modal-footer">
                <form method="POST"
                    action="{{ route('admin.users.toggle-status', $user) }}">
                    @csrf
                    @method('PATCH')

                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                        Confirm
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="resetModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
            </div>

            <div class="modal-body">
                Reset password for <strong>{{ $user->email }}</strong>?
                A new password will be emailed to the user.
            </div>

            <div class="modal-footer">
                <form method="POST"
                    action="{{ route('admin.users.reset-password', $user) }}">
                    @csrf

                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">
                        Reset Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
            </div>

            <div class="modal-body">
                Are you sure you want to delete user <strong>{{ $user->name }}</strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form method="POST"
                    action="{{ route('admin.users.destroy', $user) }}">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
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