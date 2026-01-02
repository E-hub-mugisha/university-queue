<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    <!-- <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app-dark.css') }}"> -->
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/iconly.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    
    <div id="app">
        
        @include('layouts.header')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <footer>
            <div class="container">
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; {{ config('app.name', 'Laravel') }}</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="https://saugi.me/">Saugi</a></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- <script src="{{ asset('assets/static/js/components/dark.js') }}"></script> -->
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
</body>

</html>