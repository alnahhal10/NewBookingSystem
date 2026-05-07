<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Room Type — {{ $hotel->name }}
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

                <form action="{{ route('room-types.store', $hotel->id) }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Room Type Name
                        </label>
                        <input type="text" name="name" placeholder="e.g. Standard, Deluxe, Suite"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('name') }}" required>
                    </div>

                    {{-- Base Price --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Base Price (per night)
                        </label>
                        <input type="number" name="base_price" step="0.01" placeholder="e.g. 100.00"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('base_price') }}" required>
                    </div>

                    {{-- Max Adults --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Max Adults
                        </label>
                        <input type="number" name="max_adults" min="1" placeholder="e.g. 2"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                            value="{{ old('max_adults') }}" required>
                    </div>

                    {{-- Bed Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Bed Type
                        </label>
                        <select name="bed_type"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                                   dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                            <option value="twin">Twin</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition">
                        Add Room Type
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>