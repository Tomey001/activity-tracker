<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
            {{-- Global Flash Messages --}}
@if(session('success'))
    <div id="flash-message"
         class="fixed top-4 right-4 z-50 bg-green-500 text-white 
                px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
        <span>✅</span>
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById(
                    'flash-message').style.display='none'"
                class="ml-2 text-white hover:text-green-200 font-bold">
            ×
        </button>
    </div>
    <script>
        // Auto hide after 4 seconds
        setTimeout(function() {
            var msg = document.getElementById('flash-message');
            if (msg) msg.style.display = 'none';
        }, 4000);
    </script>
@endif

@if(session('error'))
    <div id="flash-error"
         class="fixed top-4 right-4 z-50 bg-red-500 text-white 
                px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
        <span>❌</span>
        <span>{{ session('error') }}</span>
        <button onclick="document.getElementById(
                    'flash-error').style.display='none'"
                class="ml-2 text-white hover:text-red-200 font-bold">
            ×
        </button>
    </div>
    <script>
        setTimeout(function() {
            var msg = document.getElementById('flash-error');
            if (msg) msg.style.display = 'none';
        }, 4000);
    </script>
@endif

{{ $slot }}
            </main>
        </div>
        {{-- Footer --}}
<footer class="bg-white border-t border-gray-200 mt-auto py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center text-sm text-gray-500">
            <div>
                📋 Daily Activity Tracking System
                — Application Support Team
            </div>
            <div>
                Built with Laravel •
                {{ now()->format('Y') }}
            </div>
        </div>
    </div>
</footer>
    </body>
</html>
