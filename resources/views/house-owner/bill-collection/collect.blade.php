@extends('house-owner-layouts.app')

@section('title', 'Collect Payment')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collect Payment') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">Collect payment for Bill #{{ str_pad($bill->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div>
        <a href="{{ route('house-owner.bill-collections.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Collection
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

        <!-- Bill Information Card -->
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-gray-900">Bill Details</h3>
                        <p class="text-sm text-gray-600">Review bill information before collecting payment</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Bill Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Tenant Information</h4>
                        <div class="text-sm text-gray-900">
                            <p class="font-medium">{{ $bill->flat->tenant->name ?? 'No Tenant' }}</p>
                            <p class="text-gray-600">{{ $bill->flat->tenant->contact ?? 'No Contact' }}</p>
                            <p class="text-gray-600">Flat: {{ $bill->flat->flat_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Bill Information</h4>
                        <div class="text-sm text-gray-900">
                            <p>Bill ID: <span class="font-medium">#{{ str_pad($bill->id, 4, '0', STR_PAD_LEFT) }}</span></p>
                            <p>Month: <span class="font-medium">{{ \Carbon\Carbon::parse($bill->month)->format('M Y') }}</span></p>
                            <p>Status: 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Unpaid
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bill Categories -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Bill Categories</h4>
                    <div class="space-y-2">
                        @if($bill->billDetails && $bill->billDetails->count() > 0)
                            @foreach($bill->billDetails as $detail)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-900">{{ $detail->billCategory->name }}</span>
                                    <span class="text-sm font-medium text-gray-900">${{ number_format($detail->amount, 2) }}</span>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500">No categories found</p>
                        @endif
                    </div>
                </div>

                <!-- Amount Summary -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-900">Main Amount:</span>
                            <span class="text-sm font-medium text-gray-900">${{ number_format($bill->amount, 2) }}</span>
                        </div>
                        @if($bill->due_amount > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-red-600">Due Amount:</span>
                                <span class="text-sm font-medium text-red-600">${{ number_format($bill->due_amount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                            <span class="text-base font-semibold text-gray-900">${{ number_format($bill->amount + $bill->due_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('house-owner.bill-collection.update', $bill->id) }}">
            @csrf
            @method('PUT')
            
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Collect Payment</h3>
                            <p class="text-sm text-gray-600">Mark this bill as paid</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($bill->due_amount > 0)
                        <div class="mb-6">
                            <label class="text-base font-medium text-gray-900">Payment Options</label>
                            <p class="text-sm leading-5 text-gray-500 mb-4">Choose whether to include due amount in payment</p>
                            <fieldset class="space-y-4">
                                <div class="flex items-center">
                                    <input id="pay_full" name="include_due_amount" type="radio" value="1" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300" checked>
                                    <label for="pay_full" class="ml-3 block text-sm font-medium text-gray-700">
                                        Pay Full Amount 
                                        <span class="text-green-600 font-semibold">${{ number_format($bill->amount + $bill->due_amount, 2) }}</span>
                                        <span class="text-gray-500">(including due amount)</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="pay_main" name="include_due_amount" type="radio" value="0" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300">
                                    <label for="pay_main" class="ml-3 block text-sm font-medium text-gray-700">
                                        Pay Main Amount Only 
                                        <span class="text-blue-600 font-semibold">${{ number_format($bill->amount, 2) }}</span>
                                        <span class="text-gray-500">(due amount remains)</span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>
                    @else
                        <div class="mb-6">
                            <label class="text-base font-medium text-gray-900">Payment Amount</label>
                            <p class="text-sm leading-5 text-gray-500 mb-4">Full amount to be collected</p>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-2 text-green-800 font-semibold">${{ number_format($bill->amount, 2) }}</span>
                                </div>
                            </div>
                            <input type="hidden" name="include_due_amount" value="1">
                        </div>
                    @endif

                    <!-- Payment Date -->
                    <div class="mb-6">
                        <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                        <div class="mt-1">
                            <input type="date" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" class="shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Date when payment was received</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('house-owner.bill-collections.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Collect Payment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection