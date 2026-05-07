<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Your Booking 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-indigo-600 p-6 text-white">
                    <h1 class="text-2xl font-bold">Review Your Booking</h1>
                    <p class="opacity-90">Please check the details below before confirming.</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="border-b pb-4">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $room->roomType->hotel->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-400">{{ $room->roomType->hotel->address }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase">Room Type</h3>
                            <p class="text-lg text-gray-800 dark:text-gray-200">{{ $room->roomType->name }}</p>
                            <p class="text-sm text-gray-400">Room #{{ $room->room_number }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase">Dates</h3>
                            <p class="text-lg text-gray-800 dark:text-gray-200">{{ $checkIn }} -> {{ $checkOut }}</p>
                            <p class="text-sm text-gray-400">{{ $nights }} Nights</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600 dark:text-gray-300">Base Price</span>
                            <span class="text-gray-800 dark:text-gray-200">${{ $room->roomType->base_price }} x {{ $nights }} nights</span>
                        </div>
                        <hr class="my-2 border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between font-bold text-lg">
                            <span class="text-gray-800 dark:text-gray-100">Total Price</span>
                            <span class="text-indigo-600">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                    </div>

                    @if (session('error'))
                        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST" id="booking-form">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ old('room_id', $room->id) }}">
                        <input type="hidden" name="check_in" value="{{ old('check_in', $checkIn) }}">
                        <input type="hidden" name="check_out" value="{{ old('check_out', $checkOut) }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                        <button type="submit" id="booking-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 disabled:cursor-not-allowed text-white font-semibold py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                            <span id="btn-text">Confirm & Book Now</span>
                            <svg id="btn-loading" class="hidden animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ url()->previous() }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('booking-form');
    var btn = document.getElementById('booking-btn');
    var btnText = document.getElementById('btn-text');
    var btnLoading = document.getElementById('btn-loading');
    
    if (form && btn) {
        form.addEventListener('submit', function(e) {
            btn.disabled = true;
            btnText.textContent = 'Processing...';
            btnLoading.classList.remove('hidden');
        });
    }
});
</script>
