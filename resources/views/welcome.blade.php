<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flat Management System</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo/Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-blue-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Flat Management System</h1>
                <p class="text-gray-600">Choose your access portal below</p>
            </div>

            <!-- Portal Selection -->
            <div class="space-y-4">
                <!-- House Owner Portal -->
                <a href="{{ route('house-owner.login') }}" class="group block w-full">
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-200 hover:border-blue-300 group-hover:scale-[1.02]">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">House Owner Portal</h3>
                                <p class="text-sm text-gray-600">Access your building information and services</p>
                            </div>
                            <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Admin Portal -->
                <a href="{{ route('login') }}" class="group block w-full">
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-200 hover:border-emerald-300 group-hover:scale-[1.02]">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Admin Portal</h3>
                                <p class="text-sm text-gray-600">System administration and management</p>
                            </div>
                            <div class="text-gray-400 group-hover:text-emerald-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Footer -->
            <div class="text-center pt-6">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Flat Management System. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>