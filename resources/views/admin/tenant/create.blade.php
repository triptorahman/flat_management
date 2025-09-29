<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Tenant') }}
            </h2>
            <a href="{{ route('tenants.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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

            <form method="POST" action="{{ route('tenants.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- tenants Information -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h3 class="text-lg font-medium text-gray-900">Tenant Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Enter the personal details of the tenant.</p>

                        <div class="mt-6 space-y-6">
                            <!-- Tenant Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Tenant Name <span class="text-red-500">*</span></label>
                                <input type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
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
                                    value="{{ old('email') }}"
                                    required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror">
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Contact -->
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                                <input type="text"
                                    name="contact"
                                    id="contact"
                                    value="{{ old('contact') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('contact') border-red-300 @enderror">
                                @error('contact')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="building_id" class="block text-sm font-medium text-gray-700">Building</label>
                                <select name="building_id" id="building_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('building_id') border-red-300 @enderror">
                                    <option value="">-- Select Building --</option>
                                    @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label for="flat_id" class="block text-sm font-medium text-gray-700">Flat</label>
                                <select name="flat_id" id="flat_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('flat_id') border-red-300 @enderror">
                                    <option value="">-- Select Flat --</option>
                                </select>
                                @error('flat_id')
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
                                Save
                            </button>

                            <a href="{{ route('tenants.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:bg-gray-50 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#building_id').on('change', function() {
        let buildingId = $(this).val();
        if (buildingId) {
            $.ajax({
                url: '/get-flats/' + buildingId,
                type: 'GET',
                success: function(data) {
                    $('#flat_id').empty().append('<option value="">-- Select Flat --</option>');
                    $.each(data, function(key, flat) {
                        $('#flat_id').append('<option value="'+ flat.id +'">'+ flat.flat_number +'</option>');
                    });
                }
            });
        } else {
            $('#flat_id').empty().append('<option value="">-- Select Flat --</option>');
        }
    });
</script>
</x-app-layout>