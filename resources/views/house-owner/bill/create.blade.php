@extends('house-owner-layouts.app')

@section('title', 'Create Bill')

@section('header')
<div class="flex justify-between items-center">
    <div>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Bill') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1">Generate a bill for a flat</p>
    </div>
    <div>
        <a href="{{ route('house-owner.bills.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Bills
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

        <!-- Bill Creation Form -->
        <form method="POST" action="{{ route('house-owner.bills.store') }}">
            @csrf

            <!-- Bill Details -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Bill Information</h3>
                            <p class="text-sm text-gray-600">Enter the details for the new bill</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Selected Flat (Readonly) -->
                        <div class="md:col-span-1">
                            <label for="flat_display" class="block text-sm font-medium text-gray-700">
                                Selected Flat
                            </label>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="flat_id" value="{{ old('flat_id', $selectedFlatId ?? '') }}">

                            <!-- Display field (readonly) -->
                            <input type="text"
                                id="flat_display"
                                value="@if(isset($selectedFlat)){{ $selectedFlat->flat_number }}@if($selectedFlat->owner_name) - {{ $selectedFlat->owner_name }}@endif @else {{ old('flat_display', 'No flat selected') }} @endif"
                                readonly
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-700 cursor-not-allowed focus:border-gray-300 focus:ring-gray-300">

                            @error('flat_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @if(isset($selectedTenant))
                            <p class="mt-1 text-xs text-blue-600">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Tenant: {{ $selectedTenant->name }}
                            </p>
                            @elseif(isset($selectedFlat) && !$selectedFlat->tenant)
                            <p class="mt-1 text-xs text-orange-600">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                No tenant assigned to this flat
                            </p>
                            @endif

                            @if(isset($selectedFlat) && isset($dueAmount))
                                @if($dueAmount > 0)
                                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-yellow-800">
                                            Previous Due Amount: ${{ number_format($dueAmount, 2) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-yellow-700 mt-1 ml-7">
                                        This flat has unpaid bills from previous months totaling ${{ number_format($dueAmount, 2) }}
                                    </p>
                                </div>
                                @else
                                <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-md">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-green-800">
                                            No Previous Due Amount
                                        </span>
                                    </div>
                                    <p class="text-xs text-green-700 mt-1 ml-7">
                                        This flat has no outstanding balance from previous months
                                    </p>
                                </div>
                                @endif
                            @endif
                        </div>

                        <!-- Bill Categories Selection -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Select Bill Categories <span class="text-red-500">*</span>
                            </label>

                            @if(isset($billCategories) && $billCategories->count() > 0)
                            <div class="space-y-3 max-h-60 overflow-y-auto border border-gray-200 rounded-md p-4">
                                @foreach($billCategories as $category)
                                <div class="category-item border border-gray-100 rounded-lg p-3 hover:bg-gray-50">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                name="categories[]"
                                                value="{{ $category->id }}"
                                                id="category_{{ $category->id }}"
                                                onchange="toggleCategoryAmount({{ $category->id }})"
                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        </div>
                                        <div class="flex-1">
                                            <label for="category_{{ $category->id }}" class="text-sm font-medium text-gray-900 cursor-pointer">
                                                {{ $category->name }}
                                            </label>

                                            <!-- Amount Input (Hidden by default) -->
                                            <div id="amount_section_{{ $category->id }}" class="mt-2 hidden">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-1">Amount *</label>
                                                        <div class="relative">
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 text-sm">$</span>
                                                            </div>
                                                            <input type="number"
                                                                name="amounts[{{ $category->id }}]"
                                                                id="amount_{{ $category->id }}"
                                                                step="0.01"
                                                                min="0"
                                                                placeholder="0.00"
                                                                onchange="updateBillSummary()"
                                                                class="pl-7 block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-1">Description (Optional)</label>
                                                        <input type="text"
                                                            name="descriptions[{{ $category->id }}]"
                                                            id="description_{{ $category->id }}"
                                                            placeholder="Additional details..."
                                                            class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('categories')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('amounts')
                            <p class="mt-2 text-sm text-red-600">Please enter amounts for all selected categories.</p>
                            @enderror
                            @else
                            <div class="text-center py-4 text-gray-500">
                                <p>No bill categories available. Please create categories first.</p>
                                <a href="{{ route('house-owner.bill-categories.create') }}" class="text-blue-600 hover:text-blue-700 text-sm">
                                    Create Bill Category
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Bill Month -->
                        <div class="md:col-span-1">
                            <label for="month" class="block text-sm font-medium text-gray-700">
                                Bill Month <span class="text-red-500">*</span>
                            </label>
                            <input type="month"
                                name="month"
                                id="month"
                                value="{{ old('month', date('Y-m')) }}"
                                required
                                onchange="checkExistingBill()"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('month') border-red-300 @enderror">
                            @error('month')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- Warning for existing bill -->
                            <div id="existing-bill-warning" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm text-yellow-800">
                                            <strong>Warning:</strong> A bill already exists for this flat and month. Please choose a different month.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Status -->
                    <div class="md:col-span-1">
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Bill Status
                        </label>
                        <input type="text"
                            name="status"
                            id="status"
                            value="unpaid"
                            readonly
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-700 cursor-not-allowed focus:border-gray-300 focus:ring-gray-300">
                        <p class="mt-1 text-xs text-gray-500">
                            Bills are created as unpaid by default. Use the collection form to record payments.
                        </p>
                        @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bill Summary -->
                    <div class="md:col-span-2">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-md p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Bill Summary
                                    </h4>
                                    <div class="mt-3 space-y-2">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-700">Selected Categories Total:</span>
                                            <span id="current-amount-display" class="font-medium text-gray-900">0.00</span>
                                        </div>

                                        <div class="border-t border-blue-200 pt-2 mt-3">
                                            <div class="flex justify-between text-base font-semibold">
                                                <span class="text-gray-900">Total Amount:</span>
                                                <span id="total-amount-display" class="text-blue-600 text-lg">0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-center">
                                        <div class="text-xs text-gray-600 mb-1">Categories</div>
                                        <div id="selected-categories-count" class="text-2xl font-bold text-blue-600">0</div>
                                        <div class="text-xs text-gray-500">Selected</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            Notes (Optional)
                        </label>
                        <textarea name="notes"
                            id="notes"
                            rows="3"
                            placeholder="Add any additional notes about this bill..."
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('notes') border-red-300 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
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
                        Create Bill
                    </button>

                    <a href="{{ route('house-owner.bills.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:bg-gray-50 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
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

<script>
    // Check if bill already exists for the selected flat and month
    async function checkExistingBill() {
        const flatIdInput = document.querySelector('input[name="flat_id"]');
        const flatId = flatIdInput ? flatIdInput.value : null;
        const month = document.getElementById('month').value;
        const warningDiv = document.getElementById('existing-bill-warning');
        const submitButton = document.querySelector('button[type="submit"]');

        if (!flatId || !month) {
            warningDiv.classList.add('hidden');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            return;
        }

        try {
            // Make AJAX call to check for existing bill
            const formData = new FormData();
            formData.append('flat_id', flatId);
            formData.append('month', month);
            // Get CSRF token from meta tag or form
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                document.querySelector('input[name="_token"]')?.value;
            formData.append('_token', csrfToken);

            const response = await fetch('{{ route("house-owner.bills.check-existing") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.exists) {
                // Show warning
                warningDiv.classList.remove('hidden');
                warningDiv.querySelector('p').innerHTML = '<strong>Warning:</strong> ' + data.message + '. Please choose a different month or edit the existing bill.';

                // Disable submit button
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            } else {
                // Hide warning
                warningDiv.classList.add('hidden');

                // Enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

        } catch (error) {
            console.error('Error checking existing bill:', error);
            // Hide warning on error
            warningDiv.classList.add('hidden');

            // Enable submit button on error
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }





    // Toggle category amount input visibility
    function toggleCategoryAmount(categoryId) {
        const checkbox = document.getElementById('category_' + categoryId);
        const amountSection = document.getElementById('amount_section_' + categoryId);
        const amountInput = document.getElementById('amount_' + categoryId);
        const descriptionInput = document.getElementById('description_' + categoryId);

        if (checkbox.checked) {
            amountSection.classList.remove('hidden');
            amountInput.required = true;
            amountInput.focus();
        } else {
            amountSection.classList.add('hidden');
            amountInput.required = false;
            amountInput.value = '';
            descriptionInput.value = '';
        }

        updateBillSummary();
    }

    // Update bill summary with selected categories
    function updateBillSummary() {
        let totalCategoryAmount = 0;
        let selectedCategories = 0;

        // Calculate total from selected categories
        const checkboxes = document.querySelectorAll('input[name="categories[]"]:checked');
        checkboxes.forEach(function(checkbox) {
            const categoryId = checkbox.value;
            const amountInput = document.getElementById('amount_' + categoryId);
            const amount = parseFloat(amountInput.value) || 0;
            totalCategoryAmount += amount;
            selectedCategories++;
        });

        // Update display elements - only current amount since we don't store due amounts
        document.getElementById('current-amount-display').textContent = '$' + totalCategoryAmount.toFixed(2);
        document.getElementById('total-amount-display').textContent = '$' + totalCategoryAmount.toFixed(2);

        document.getElementById('selected-categories-count').textContent = selectedCategories;

        // Update form validation
        const submitButton = document.querySelector('button[type="submit"]');
        if (selectedCategories === 0) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateBillSummary();
    });
</script>
@endsection