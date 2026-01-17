@extends('layouts.app')
@section('title', 'User Management')
@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">

            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="nk-block-title">User Management</h4>
                            <div class="d-flex gap-2">
                                <!-- Add User Button -->
                                <button class="btn btn-primary mb-3 p-3" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">Add User</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Users Table -->
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nowrap nk-tb-list nk-tb-ulist"
                            data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">Name</th>
                                    <th class="nk-tb-col">Email</th>
                                    <th class="nk-tb-col">Verified</th>
                                    <th class="nk-tb-col">Role</th>
                                    <th class="nk-tb-col">Status</th>
                                    <th class="nk-tb-col nk-tb-col-tools text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col">{{ $user->name }}</td>
                                    <td class="nk-tb-col">{{ $user->email }}</td>
                                    <td class="nk-tb-col">
                                        @if($user->email_verified_at)
                                        <span class="badge bg-success">Verified</span>
                                        @else
                                        <span class="badge bg-warning text-dark">Unverified</span>
                                        @endif
                                    </td>
                                    <td class="nk-tb-col">{{ ucfirst($user->role) }}</td>
                                    <td class="nk-tb-col">
                                        @if(!$user->is_active)
                                        <span class="badge bg-danger">Disabled</span>
                                        @else
                                        <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#"
                                                        class="dropdown-toggle btn btn-icon btn-trigger"
                                                        data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a role="button" class="text-warning" data-bs-toggle="modal" data-bs-target="#userModal"
                                                                    onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">Edit</a>
                                                            </li>
                                                            @if(!$user->email_verified_at)
                                                            <li>
                                                                <a role="button"
                                                                    class="text-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#verifyUserModal{{ $user->id }}">
                                                                    <i class="bi bi-patch-check"></i> Verify
                                                                </a>
                                                            </li>
                                                            @endif
                                                            <li>
                                                                <!-- Disable / Enable -->
                                                                <a role="button" class="{{ $user->is_active ? 'text-warning' : 'text-success' }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#statusModal{{ $user->id }}">
                                                                    <i class="bi {{ $user->is_active ? 'bi-person-x' : 'bi-person-check' }}"></i>
                                                                    {{ $user->is_active ? 'Disable' : 'Enable' }}
                                                                </a>
                                                            </li>
                                                            <li>

                                                                <!-- Reset Password -->
                                                                <a role="button" class="text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#resetModal{{ $user->id }}">
                                                                    <i class="bi bi-key"></i>Reset Password
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <!-- Delete User -->
                                                                <a role="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">Delete</a>
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
@foreach($users as $user)
<div class="modal fade" id="verifyUserModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-shield-check"></i> Verify User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p>
                    Are you sure you want to verify this user?
                </p>

                <h6 class="fw-bold">{{ $user->name }}</h6>
                <small class="text-muted">{{ $user->email }}</small>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <form method="POST" action="{{ route('admin.users.verify', $user) }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Verify User
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

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

@if(session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast show align-items-center text-bg-success border-0">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endif
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