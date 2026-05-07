<section class="mb-8">
    <h2 class="mb-4 text-xl font-semibold text-gray-900">Featured Hotels</h2>
    @if($featuredHotels->isEmpty())
        <p class="text-gray-600">No featured hotels at the moment.</p>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($featuredHotels as $hotel)
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-800">{{ $hotel->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $hotel->city }}, {{ $hotel->country }}</p>
                    <a href="{{ route('hotels.show', $hotel) }}" class="mt-2 inline-block text-indigo-600 hover:underline">
                        View details
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</section>