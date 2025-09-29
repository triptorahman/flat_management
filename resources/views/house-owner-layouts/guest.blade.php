<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'House Owner Login') - {{ config('app.name', 'Flat Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 to-indigo-100">
            <!-- Header with Logo -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full p-4 shadow-lg">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">House Owner Portal</h1>
                <p class="text-gray-600">Manage your building and tenants with ease</p>
            </div>

            <!-- Login Form Card -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl border border-gray-200">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Need help? 
                    <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">Contact Support</a>
                </p>
                <div class="mt-4 flex justify-center space-x-6">
                    <a href="/" class="text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Main Site
                    </a>
                    <span class="text-gray-400">•</span>
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Admin Login
                    </a>
                </div>
                <div class="mt-2">
                    <p class="text-xs text-gray-400">House Owner Portal • Use your house owner credentials</p>
                </div>
            </div>
        </div>
        
        @stack('scripts')
    </body>
</html>
