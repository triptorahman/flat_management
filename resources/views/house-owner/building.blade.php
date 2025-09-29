@extends('house-owner-layouts.app')

@section('title', 'My Building')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Building') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">Manage your building details and settings</p>
    </div>
    @if($building)
    <div class="text-right">
        <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Building
        </button>
    </div>
    @endif
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($building)
        <!-- Building Overview -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600">
                <div class="flex items-center text-white">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold">{{ $building->name }}</h1>
                        <p class="text-blue-100">{{ $building->address }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Building Stats -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Building Statistics</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-600">Total Flats</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $building->total_flats }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-600">Occupied</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $building->occupied_flats }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2M5 9V7a2 2 0 012-2h10a2 2 0 012 2v2M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-600">Total Floors</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $building->floors ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-600">Built Year</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $building->construction_year ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Occupancy Chart -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Occupancy Status</h3>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            @php
                                $occupancyRate = $building->total_flats > 0 ? ($building->occupied_flats / $building->total_flats) * 100 : 0;
                            @endphp
                            <div class="relative inline-flex items-center justify-center w-32 h-32">
                                <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-gray-300" fill="none" stroke="currentColor" stroke-width="3" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                    <path class="text-blue-600" fill="none" stroke="currentColor" stroke-width="3" stroke-dasharray="{{ $occupancyRate }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                </svg>
                                <div class="absolute text-center">
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($occupancyRate, 1) }}%</span>
                                    <p class="text-xs text-gray-600">Occupied</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Building Details -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Building Details</h3>
                <p class="text-sm text-gray-600">Complete information about your building</p>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Building Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $building->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Building Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $building->building_type ?: 'Not specified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $building->address }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Construction Year</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $building->construction_year ?: 'Not specified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Floors</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $building->floors ?: 'Not specified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Flats</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $building->total_flats }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $building->description ?: 'No description available' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        
        @else
        <!-- No Building Assigned -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Building Assigned</h3>
                <p class="mt-2 text-sm text-gray-500">You don't have any building assigned to your account yet. Please contact your administrator to get a building assigned.</p>
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection