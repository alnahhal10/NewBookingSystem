<section class="mb-8">
    <h2 class="mb-4 text-xl font-semibold text-gray-900">Upcoming Reservations</h2>
    @if($upcomingReservations->isEmpty())
        <p class="text-gray-600">You have no upcoming reservations.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Hotel</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Room</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Check‑in</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Check‑out</th>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($upcomingReservations as $booking)
                        @php
                            $room = $booking->room;
                            $hotel = $room?->roomType?->hotel;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 text-gray-700">{{ $hotel?->name ?? 'N/A' }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $room?->room_number ?? 'N/A' }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $booking->check_in?->format('M d, Y') ?? '-' }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $booking->check_out?->format('M d, Y') ?? '-' }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ ucfirst($booking->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>