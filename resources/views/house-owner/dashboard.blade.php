@extends('house-owner-layouts.app')

@section('title', 'Dashboard')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">Welcome back, {{ auth('house_owner')->user()->name }}!</p>
    </div>
    <div class="text-right">
        <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium">Welcome to Your House Owner Portal</h3>
                        <p class="text-blue-100">Manage your building, tenants, and property details all in one place.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Building Info Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">My Building</p>
                            @if($building)
                                <p class="text-lg font-semibold text-gray-900">{{ $building->name }}</p>
                                <p class="text-xs text-gray-500">{{ $building->address }}</p>
                            @else
                                <p class="text-sm text-gray-500">No building assigned</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Flats Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Flats</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $building ? $building->total_flats : '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Occupied Flats Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Occupied</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $building ? $building->occupied_flats : '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Flats Card -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Available</p>
                            @if($building)
                                <p class="text-2xl font-bold text-gray-900">{{ $building->total_flats - $building->occupied_flats }}</p>
                            @else
                                <p class="text-2xl font-bold text-gray-900">0</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Building Details Card -->
        @if($building)
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Building Information</h3>
                <p class="text-sm text-gray-600">Details about your managed building</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Basic Information</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Building Name</dt>
                                <dd class="text-sm text-gray-900">{{ $building->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="text-sm text-gray-900">{{ $building->address }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Construction Year</dt>
                                <dd class="text-sm text-gray-900">{{ $building->construction_year ?: 'Not specified' }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Property Details</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Floors</dt>
                                <dd class="text-sm text-gray-900">{{ $building->floors ?: 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Building Type</dt>
                                <dd class="text-sm text-gray-900 capitalize">{{ $building->building_type ?: 'Not specified' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900">{{ $building->description ?: 'No description available' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Building Assigned</h3>
                <p class="mt-1 text-sm text-gray-500">Contact your administrator to get a building assigned to your account.</p>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                <p class="text-sm text-gray-600">Common tasks you can perform</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Manage Building
                    </a>
                    
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        View Tenants
                    </a>
                    
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection