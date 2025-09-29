@extends('house-owner-layouts.app')

@section('title', 'Flat Details')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Flat Details') }} - {{ $flat->flat_number }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">View flat information in {{ $flat->building->name }}</p>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('house-owner.flats.edit', $flat) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Flat
        </a>
        <a href="{{ route('house-owner.flats.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Flats
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Building Information -->
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-gray-900">{{ $flat->building->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $flat->building->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flat Information -->
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Flat Information</h3>
                <p class="text-sm text-gray-600">Complete details about this flat</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Basic Details</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Flat Number</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $flat->flat_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Building</dt>
                                <dd class="text-sm text-gray-900">{{ $flat->building->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd>
                                    @if($flat->tenants->count() > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"></circle>
                                            </svg>
                                            Occupied
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"></circle>
                                            </svg>
                                            Available
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Timestamps</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created On</dt>
                                <dd class="text-sm text-gray-900">{{ $flat->created_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            @if($flat->updated_at != $flat->created_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="text-sm text-gray-900">{{ $flat->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total Tenants</dt>
                                <dd class="text-sm text-gray-900">{{ $flat->tenants->count() }} tenant(s)</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        @if($flat->owner_name || $flat->owner_contact || $flat->owner_email)
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Owner Information</h3>
                <p class="text-sm text-gray-600">Details about the flat owner/resident</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <dl class="space-y-3">
                        @if($flat->owner_name)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="text-sm text-gray-900">{{ $flat->owner_name }}</dd>
                        </div>
                        @endif
                        @if($flat->owner_contact)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contact</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="tel:{{ $flat->owner_contact }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $flat->owner_contact }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        @if($flat->owner_email)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="mailto:{{ $flat->owner_email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $flat->owner_email }}
                                </a>
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
        @endif

        <!-- Tenants Information -->
        @if($flat->tenants->count() > 0)
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Current Tenants</h3>
                <p class="text-sm text-gray-600">{{ $flat->tenants->count() }} tenant(s) currently living in this flat</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($flat->tenants as $tenant)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $tenant->name ?? 'Tenant Name' }}</p>
                                <p class="text-sm text-gray-500">{{ $tenant->contact ?? 'No contact info' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                <p class="text-sm text-gray-600">Manage this flat</p>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('house-owner.flats.edit', $flat) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection