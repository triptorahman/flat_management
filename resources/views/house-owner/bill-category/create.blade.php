@extends('house-owner-layouts.app')

@section('title', 'Create Bill Category')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Bill Category') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">Add a new category to organize your bills</p>
    </div>
    <div>
        <a href="{{ route('house-owner.bill-categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Categories
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
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

        <!-- Bill Category Creation Form -->
        <form method="POST" action="{{ route('house-owner.bill-categories.store') }}">
            @csrf
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Category Information</h3>
                            <p class="text-sm text-gray-600">Enter the name for your new bill category</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Category Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="e.g., Utilities, Maintenance, Rent, Insurance"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Choose a descriptive name for this category. This will help you organize your bills.</p>
                        </div>

                        <!-- Examples Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Suggested Categories</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Common bill categories include:</p>
                                        <ul class="mt-1 list-disc list-inside">
                                            <li>Utilities (Electricity, Water, Gas)</li>
                                            <li>Maintenance & Repairs</li>
                                            <li>Security Services</li>
                                            <li>Insurance & Property Tax</li>
                                            <li>Cleaning & Housekeeping</li>
                                            <li>Internet & Cable</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
                                Create Category
                            </button>
                            
                            <a href="{{ route('house-owner.bill-categories.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:bg-gray-50 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
