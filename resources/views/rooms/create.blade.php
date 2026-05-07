<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Room — {{ $hotel->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 text-red-600 text-sm">
                        <ul>@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('rooms.store', $hotel->id) }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                    {{-- Room Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Room Type
                        </label>
                        <select name="room_type_id" 
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select Type --</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Room Number --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Room Number
                        </label>
                        <input type="text" name="room_number" placeholder="e.g. 101, A2"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('room_number') }}" required>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status
                        </label>
                        <select name="status" required
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="occupied">Occupied</option>
                        </select>
                    </div>
                    {{-- Floor Number --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Floor Number (optional)
                        </label>
                        <input type="number" name="floor_number" placeholder="e.g. 1, 2, 3"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('floor_number') }}">

                    <button type="submit"
                        class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition">
                        Add Room
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>