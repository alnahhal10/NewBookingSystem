
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Bookings
        </h2>
    </x-slot>
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">My Bookings</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($bookings->isEmpty())
        <p>You have no bookings yet.</p>
    @else
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-lg">{{ $booking->room->roomType->name ?? 'Room Deleted' }}</h3>
                        <p class="text-gray-600">Hotel: {{ $booking->room->roomType->hotel->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $booking->check_in->format('M d, Y') }} - {{ $booking->check_out->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-indigo-600">${{ $booking->total_price }}</p>
                        <p class="text-xs uppercase px-2 py-1 rounded bg-green-100 text-green-800 inline-block mb-1">{{ $booking->status }}</p>
                        @if($booking->payment_status !== 'paid')
                            <p class="text-xs uppercase px-2 py-1 rounded bg-yellow-100 text-yellow-800 inline-block mb-1">Unpaid</p>
                        @else
                            <p class="text-xs uppercase px-2 py-1 rounded bg-green-100 text-green-800 inline-block mb-1">Paid</p>
                        @endif
                        @if($booking->payment_status !== 'paid')
                            <form action="{{ route('bookings.pay', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-semibold">
                                    Pay Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>
