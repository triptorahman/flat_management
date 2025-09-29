<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit House Owner & Building') }}
            </h2>
            <a href="{{ route('house-owners.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
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

            <!-- Display General Error Message -->
            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('house-owners.update', $houseOwner) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- House Owner Information -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900">House Owner Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Update the personal details of the house owner.</p>
                        
                        <div class="mt-6 space-y-6">
                            <!-- Owner Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Owner Name <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $houseOwner->name) }}"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $houseOwner->email) }}"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-gray-500">(leave blank to keep current)</span></label>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-300 @enderror">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact -->
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                                <input type="text" 
                                       name="contact" 
                                       id="contact" 
                                       value="{{ old('contact', $houseOwner->contact) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('contact') border-red-300 @enderror">
                                @error('contact')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Building Information -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900">Building Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Update the details of the building owned by this house owner.</p>
                        
                        <div class="mt-6 space-y-6">
                            <!-- Building Name -->
                            <div>
                                <label for="building_name" class="block text-sm font-medium text-gray-700">Building Name <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       name="building_name" 
                                       id="building_name" 
                                       value="{{ old('building_name', $houseOwner->building->name ?? '') }}"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('building_name') border-red-300 @enderror">
                                @error('building_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Building Address -->
                            <div>
                                <label for="building_address" class="block text-sm font-medium text-gray-700">Building Address <span class="text-red-500">*</span></label>
                                <textarea name="building_address" 
                                          id="building_address" 
                                          rows="3"
                                          required
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('building_address') border-red-300 @enderror">{{ old('building_address', $houseOwner->building->address ?? '') }}</textarea>
                                @error('building_address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update House Owner & Building
                            </button>
                            
                            <a href="{{ route('house-owners.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:bg-gray-50 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-generate building name suggestion based on owner name (only if building name is empty)
        document.getElementById('name').addEventListener('input', function() {
            const ownerName = this.value;
            const buildingNameField = document.getElementById('building_name');
            
            // Only suggest if building name field is completely empty
            if (ownerName && buildingNameField.value.trim() === '') {
                buildingNameField.value = ownerName + ' Building';
            }
        });

        // Add form submission debugging
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submitted for editing');
            console.log('Form data:');
            const formData = new FormData(this);
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }
        });

        // Check for validation errors on page load
        window.addEventListener('load', function() {
            const errors = document.querySelectorAll('.text-red-600');
            if (errors.length > 0) {
                console.log('Validation errors found:', errors.length);
            }
        });
    </script>
</x-app-layout>
