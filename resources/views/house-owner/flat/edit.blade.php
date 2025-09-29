@extends('house-owner-layouts.app')

@section('title', 'Edit Flat')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Flat') }} - {{ $flat->flat_number }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">Update flat details in {{ $building->name }}</p>
    </div>
    <div class="flex items-center space-x-3">
        
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

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                        <h3 class="text-lg font-medium text-gray-900">{{ $building->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $building->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flat Edit Form -->
        <form method="POST" action="{{ route('house-owner.flats.update', $flat) }}">
            @csrf
            @method('PUT')
            
            <!-- Flat Details -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Flat Details</h3>
                    <p class="text-sm text-gray-600">Update the basic information for this flat</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Flat Number -->
                        <div class="md:col-span-1">
                            <label for="flat_number" class="block text-sm font-medium text-gray-700">
                                Flat Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="flat_number" 
                                   id="flat_number" 
                                   value="{{ old('flat_number', $flat->flat_number) }}"
                                   required
                                   placeholder="e.g., 101, A-1, 2B"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('flat_number') border-red-300 @enderror">
                            @error('flat_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Flat number must be unique within the building</p>
                        </div>

                        <!-- Creation Info -->
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Created On</label>
                            <div class="mt-1 text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-md border">
                                {{ $flat->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                            @if($flat->updated_at != $flat->created_at)
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <div class="mt-1 text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-md border">
                                        {{ $flat->updated_at->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flat Owner Information -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Flat Owner Information</h3>
                    <p class="text-sm text-gray-600">Update details about the flat owner/resident</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Owner Name -->
                        <div>
                            <label for="owner_name" class="block text-sm font-medium text-gray-700">
                                Owner/Resident Name
                            </label>
                            <input type="text" 
                                   name="owner_name" 
                                   id="owner_name" 
                                   value="{{ old('owner_name', $flat->owner_name) }}"
                                   placeholder="Enter full name"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('owner_name') border-red-300 @enderror">
                            @error('owner_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Owner Contact -->
                        <div>
                            <label for="owner_contact" class="block text-sm font-medium text-gray-700">
                                Contact Number
                            </label>
                            <input type="text" 
                                   name="owner_contact" 
                                   id="owner_contact" 
                                   value="{{ old('owner_contact', $flat->owner_contact) }}"
                                   placeholder="e.g., +1234567890"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('owner_contact') border-red-300 @enderror">
                            @error('owner_contact')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Owner Email -->
                        <div class="md:col-span-2">
                            <label for="owner_email" class="block text-sm font-medium text-gray-700">
                                Email Address
                            </label>
                            <input type="email" 
                                   name="owner_email" 
                                   id="owner_email" 
                                   value="{{ old('owner_email', $flat->owner_email) }}"
                                   placeholder="owner@example.com"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('owner_email') border-red-300 @enderror">
                            @error('owner_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Flat
                            </button>
                            
                            
                            <a href="{{ route('house-owner.flats.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:bg-gray-50 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            <p>* Required fields</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
