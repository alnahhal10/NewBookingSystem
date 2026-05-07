<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Hotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('hotels.show', $hotel->id) }}"
                   class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Hotel
                </a>
            </div>

            {{-- Main Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">

                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <h3 class="text-xl font-bold text-white">Edit Hotel Information</h3>
                    </div>
                </div>

                <div class="p-6">
                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center gap-2 text-red-700 dark:text-red-300 mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold">Please fix the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 text-red-600 dark:text-red-400 text-sm ml-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        {{-- Hotel Name --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Hotel Name
                            </label>
                            <input type="text"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition @error('name') border-red-500 @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $hotel->name) }}"
                                   placeholder="Enter hotel name"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition @error('description') border-red-500 @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Describe the hotel...">{{ old('description', $hotel->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- City and Rating Row --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- City --}}
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    City
                                </label>
                                <input type="text"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition @error('city') border-red-500 @enderror"
                                       id="city"
                                       name="city"
                                       value="{{ old('city', $hotel->city) }}"
                                       placeholder="e.g., New York"
                                       required>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Rating --}}
                            <div>
                                <label for="rating" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Rating (1-5)
                                </label>
                                <input type="number"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition @error('rating') border-red-500 @enderror"
                                       id="rating"
                                       name="rating"
                                       min="1"
                                       max="5"
                                       value="{{ old('rating', $hotel->rating) }}"
                                       placeholder="5">
                                @error('rating')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Image Section --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Current Image
                            </label>
                            @php $imgs = json_decode($hotel->images, true); @endphp
                            @if(!empty($imgs))
                                <div class="mb-4">
                                    <img src="{{ $imgs[0] }}"
                                         class="w-48 h-32 object-cover rounded-lg shadow-md"
                                         alt="{{ $hotel->name }}">
                                </div>
                            @endif

                            <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Upload New Image
                            </label>
                            <input type="file"
                                   accept="image/*"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                   id="image"
                                   name="image">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to keep current image</p>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit"
                                    class="inline-flex justify-center items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Hotel
                            </button>
                            <a href="{{ route('hotels.show', $hotel->id) }}"
                               class="inline-flex justify-center items-center gap-2 px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
