<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'House Owner Portal') - {{ config('app.name', 'Flat Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
            @include('house-owner-layouts.navigation')

            <!-- Page Heading -->
            @if(isset($header) || View::hasSection('header'))
                <header class="bg-white shadow-lg">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @if(isset($header))
                            {{ $header }}
                        @else
                            @yield('header')
                        @endif
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-6">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
        
        @stack('scripts')
    </body>
</html>
