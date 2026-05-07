<x-app-layout>
   
    <div class="bg-gray-50">
        <!-- Booking-like hero with photo background -->
        <div class="relative">
            <div
                class="h-[340px] sm:h-[380px] bg-cover bg-center"
                style="background-image: url('{{ asset('images/hero-booking.svg') }}');"
            >
                <div class="absolute inset-0 bg-[#003580]/85"></div>
            </div>

            <div class="absolute inset-0">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
                    <div class="w-full">
                        <h1 class="text-3xl sm:text-5xl font-semibold tracking-tight text-white">
                            Dubai: find your next stay
                        </h1>
                        <p class="mt-3 text-white/90 max-w-2xl">
                            Search deals on hotels, homes, and much more.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Search bar card -->
            <div class="-mt-10 sm:-mt-12 relative z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="rounded-xl border border-yellow-400 bg-yellow-400 p-2 shadow-lg">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                                <div class="md:col-span-5">
                                    <div class="bg-white rounded-lg px-3 py-2">
                                        <label class="block text-xs font-medium text-gray-600" for="city">Destination</label>
                                        <input
                                            id="city"
                                            name="city"
                                            type="text"
                                            placeholder="Where are you going?"
                                            value="{{ request('city', $city ?? 'Dubai') }}"
                                            class="w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0"
                                        />
                                    </div>
                                </div>
                                <div class="md:col-span-3">
                                    <div class="bg-white rounded-lg px-3 py-2">
                                        <label class="block text-xs font-medium text-gray-600" for="check_in">Check-in</label>
                                        <input
                                            id="check_in"
                                            name="check_in"
                                            type="date"
                                            value="{{ request('check_in') }}"
                                            class="w-full border-0 p-0 text-gray-900 focus:ring-0"
                                        />
                                    </div>
                                </div>
                                <div class="md:col-span-3">
                                    <div class="bg-white rounded-lg px-3 py-2">
                                        <label class="block text-xs font-medium text-gray-600" for="check_out">Check-out</label>
                                        <input
                                            id="check_out"
                                            name="check_out"
                                            type="date"
                                            value="{{ request('check_out') }}"
                                            class="w-full border-0 p-0 text-gray-900 focus:ring-0"
                                        />
                                    </div>
                                </div>
                                <div class="md:col-span-1">
                                    <button
                                        type="submit"
                                        class="w-full h-full rounded-lg bg-[#0071c2] text-white font-semibold hover:bg-[#005fa3] px-4 py-3"
                                    >
                                        Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if(request()->filled('city') || request()->filled('check_in') || request()->filled('check_out'))
                            <div class="mt-2">
                                <a href="{{ url()->current() }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                    Clear filters
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Hotels</h2>
                    <p class="text-sm text-gray-600">Browse and open a hotel to see rooms.</p>
                </div>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('hotels.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 text-white px-4 py-2 text-sm font-medium hover:bg-indigo-700">
                            Add hotel
                        </a>
                    @endif
                @endauth
            </div>

            @if($hotels->isEmpty())
                <div class="mt-6 rounded-xl border bg-white p-8 text-center">
                    <p class="text-gray-700 font-medium">No hotels found.</p>
                    <p class="text-gray-500 text-sm mt-1">Try searching with a different city.</p>
                </div>
            @else
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($hotels as $hotel)
                        <div class="rounded-2xl border bg-white p-5 shadow-sm hover:shadow transition">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <a href="{{ route('hotels.show', $hotel) }}" class="text-lg font-semibold text-gray-900 hover:underline">
                                        {{ $hotel->name }}
                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $hotel->city ?? '—' }}, {{ $hotel->country ?? '—' }}
                                    </p>
                                </div>
                                <div class="shrink-0 rounded-lg bg-gray-100 px-2 py-1 text-sm text-gray-700">
                                    ⭐ {{ $hotel->star_rating ?? 0 }}/5
                                </div>
                            </div>

                            @if(!empty($hotel->description))
                                <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                                    {{ $hotel->description }}
                                </p>
                            @endif

                            <div class="mt-4 flex items-center justify-between">
                                <a href="{{ route('hotels.show', $hotel) }}" class="text-sm font-medium text-indigo-700 hover:text-indigo-800">
                                    View rooms →
                                </a>

                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('hotels.edit', $hotel) }}" class="text-sm text-gray-600 hover:text-gray-900">
                                                Edit
                                            </a>
                                            <form action="{{ route('hotels.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    <!--  -->
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

