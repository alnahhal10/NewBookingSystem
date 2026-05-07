<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $hotel->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Hotel Info Card --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Image --}}
                        <div class="w-full md:w-1/3">
                            @php $imgs = json_decode($hotel->images, true); @endphp
                            @if(!empty($imgs))
                                <img src="{{ $imgs[0] }}" class="rounded-lg w-full h-48 object-cover" alt="{{ $hotel->name }}">
                            @else
                                <div class="bg-gray-200 h-48 rounded-lg flex items-center justify-center">
                                    No Image
                                </div>
                            @endif
                        </div>
                        
                        {{-- Details --}}
                        <div class="w-full md:w-2/3">

                            
                             {{-- بعد زر Edit و Delete --}}
                             @auth
                             @role('admin')
                            <a href="{{ route('rooms.create', ['hotel' => $hotel->id]) }}"
                            class=" block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                                + Add Room
                            </a><br>
                            <a href="{{ route('room-types.create', ['hotel' => $hotel->id]) }}"
                            class=" block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                                + Add RoomType
                            </a><br>
                            <a href="{{ route('hotels.edit', $hotel->id) }}"  class=" block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">Edit</a><br>    
                                    <form action="{{ route('hotels.destroy', $hotel->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class=" block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">Delete</button>
                                    </form>
                            @endrole
                            @endauth
                            <h1 class="text-3xl font-bold mb-2">{{ $hotel->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}</p>

                            <form id="availability-form" action="{{ route('hotels.show', $hotel) }}" method="GET" class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg mb-4">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                                    <div>
                                        <label for="check_in" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Check-in</label>
                                        <input
                                            id="check_in"
                                            name="check_in"
                                            type="date"
                                            value="{{ $checkIn }}"
                                            min="{{ now()->toDateString() }}"
                                            class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            required
                                        >
                                    </div>
                                    <div>
                                        <label for="check_out" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Check-out</label>
                                        <input
                                            id="check_out"
                                            name="check_out"
                                            type="date"
                                            value="{{ $checkOut }}"
                                            min="{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->addDay()->toDateString() : now()->addDay()->toDateString() }}"
                                            class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                            required
                                        >
                                    </div>
                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition">
                                        Check Availability
                                    </button>
                                </div>
                            </form>
                            
                            {{-- Dates Display --}}
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg inline-block">
                                <p><strong>Your Dates:</strong> 
                                    {{ $checkIn ?? 'Not Selected' }} 
                                    <span class="mx-2">→</span> 
                                    {{ $checkOut ?? 'Not Selected' }}
                                </p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            {{-- Available Rooms Section --}}
            <h3 id="available-rooms" class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200 scroll-mt-24">Available Rooms</h3>

            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 p-4 rounded-lg border border-red-200 dark:border-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if($availableRooms->isEmpty())
                <div class="bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 p-6 rounded-lg border border-red-200 dark:border-red-800">
                    <p class="font-semibold">No rooms available for these dates.</p>
                    <p class="text-sm mt-1">Try selecting different dates.</p>
                </div>
            @else
                <div id="available-rooms-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 scroll-mt-24">
                    @foreach($availableRooms as $room)
                        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-xl shadow-sm overflow-hidden flex flex-col">
                            {{-- Room Card Content --}}
                            <div class="p-6 flex-grow">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $room->roomType->name }}</h4>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 space-y-1">
                                    <p>Room #: {{ $room->room_number }}</p>
                                    <p>Bed: {{ $room->roomType->bed_type }}</p>
                                    <p>Capacity: {{ $room->roomType->max_adults }} Adults, {{ $room->roomType->max_children }} Children</p>
                                </div>
                                
                                @php 
                                    $nights = 0;
                                    if($checkIn && $checkOut) {
                                        $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)); 
                                    }
                                @endphp
                            </div>

                            {{-- Price & Action --}}
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 flex justify-between items-center">
                                <div>
                                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ $room->roomType->base_price }}</span>
                                    <span class="text-sm text-gray-500">/night</span>
                                    @if($nights > 0)
                                        <p class="text-xs text-gray-400">Total: ${{ $room->roomType->base_price * $nights }}</p>
                                    @endif
                                </div>
                                 
                                @if($checkIn && $checkOut)
                                    {{-- Book Button --}}
                                    <a href="{{ route('bookings.create', [
                                        'room_id' => $room->id, 
                                        'check_in' => $checkIn, 
                                        'check_out' => $checkOut
                                    ]) }}" 
                                       class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition">
                                        Book Now
                                    </a>
                                @else
                                    <span class="px-6 py-2 bg-gray-300 text-gray-600 rounded-lg font-semibold cursor-not-allowed">
                                        Select Dates
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                
                                

            @endif

                                    
            <div class="mt-8">
                <a href="{{ url()->previous() }}" class="text-indigo-600 hover:underline">&larr; Back to Search</a>
            </div>
        </div>
    </div>

    <script>
    (function() {
        var form = document.getElementById('availability-form');

        if (form) {
            form.addEventListener('submit', function() {
                sessionStorage.setItem('scrollToAvailableRooms', '1');
            });
        }

        window.addEventListener('load', function() {
            var params = new URLSearchParams(window.location.search);
            var shouldScroll = sessionStorage.getItem('scrollToAvailableRooms') === '1'
                || (params.has('check_in') && params.has('check_out'));

            if (! shouldScroll) {
                return;
            }

            sessionStorage.removeItem('scrollToAvailableRooms');

            var roomsTarget = document.getElementById('available-rooms-list') || document.getElementById('available-rooms');

            if (roomsTarget) {
                setTimeout(function() {
                    var top = roomsTarget.getBoundingClientRect().top + window.pageYOffset - 90;

                    window.scrollTo({
                        top: top,
                        behavior: 'smooth'
                    });
                }, 300);
            }
        });
    })();
    </script>
</x-app-layout>
