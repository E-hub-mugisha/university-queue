<?php

if (!function_exists('activeClass')) {
    function activeClass($routeNames, $class = 'active')
    {
        if (is_array($routeNames)) {
            foreach ($routeNames as $route) {
                if (request()->routeIs($route)) {
                    return $class;
                }
            }
        } else {
            if (request()->routeIs($routeNames)) {
                return $class;
            }
        }

        return '';
    }
}
?>

<style>
    .nav-link.active {
        background-color: #435ebe;
        color: #fff !important;
        border-radius: 6px;
    }

    .nav-link.active i {
        color: #fff;
    }
</style>

<header class="mb-5">
    <div class="header-top bg-light py-2 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Logo -->
            <div class="logo">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/logo.svg') }}" alt="Logo" height="40">
                </a>
            </div>

            <!-- Main Navbar -->
            <nav class="main-navbar shadow-sm">
                <div class="container">
                    <ul class="nav">

                        {{-- Dashboard - visible to all --}}
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ activeClass('dashboard') }}">
                                <i class="bi bi-grid-fill me-1"></i> Dashboard
                            </a>
                        </li>

                        @php $role = Auth::user()->role; @endphp

                        {{-- Admin-only menus --}}
                        @if($role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ activeClass('admin.users.*') }}">
                                <i class="bi bi-people-fill me-1"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.departments.index') }}" class="nav-link {{ activeClass('admin.departments.*') }}">
                                <i class="bi bi-building me-1"></i> Departments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.faculties.index') }}" class="nav-link {{ activeClass('admin.faculties.*') }}">
                                <i class="bi bi-mortarboard-fill me-1"></i> Faculties
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.staff.index') }}" class="nav-link {{ activeClass('admin.staff.*') }}">
                                <i class="bi bi-person-badge-fill me-1"></i> Staff
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.index') }}" class="nav-link {{ activeClass('admin.students.*') }}">
                                <i class="bi bi-person-lines-fill me-1"></i> Students
                            </a>
                        </li>
                        @endif

                        {{-- Staff menus --}}
                        @if($role === 'staff')
                        <li class="nav-item">
                            <a href="{{ route('staff.requests.index') }}" class="nav-link {{ activeClass('staff.requests.*') }}">
                                <i class="bi bi-list-ul me-1"></i> Assigned Requests
                            </a>
                        </li>
                        @endif

                        {{-- Student menus --}}
                        @if($role === 'student')
                        <li class="nav-item">
                            <a href="{{ route('student.requests.index') }}" class="nav-link {{ activeClass('student.requests.*') }}">
                                <i class="bi bi-list-check me-1"></i> My Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.requests.create') }}" class="nav-link {{ activeClass('student.requests.create') }}">
                                <i class="bi bi-plus-circle me-1"></i> Submit Request
                            </a>
                        </li>
                        @endif

                    </ul>

                </div>
            </nav>
            <!-- User Dropdown + Burger -->
            <div class="d-flex align-items-center">

                <!-- User Dropdown -->
                <div class="dropdown me-3">
                    <a href="#" id="userDropdown" class="d-flex align-items-center dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar me-2">
                            <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Avatar" class="rounded-circle" width="40">
                        </div>
                        <div class="text">
                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">My Account</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <!-- Proper logout -->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-list fs-3"></i>
                </a>

            </div>
        </div>
    </div>

</header>