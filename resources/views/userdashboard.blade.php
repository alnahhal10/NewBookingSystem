<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-900">
                    {{ __('dashboard.title') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('dashboard.subtitle') }}
                </p>
            </div>
            <a href="{{ route('hotels.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                {{ __('dashboard.view_public_hotels') }}
            </a>
        </div>
    </x-slot>

    @php
        $statusStyles = [
            'available' => 'bg-green-100 text-green-800',
            'booked' => 'bg-blue-100 text-blue-800',
            'maintenance' => 'bg-amber-100 text-amber-800',
            'out_of_service' => 'bg-red-100 text-red-800',
            'occupied' => 'bg-blue-100 text-blue-800',
        ];

        $bookingStatusStyles = [
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-gray-100 text-gray-800',
        ];

        $paymentStatusStyles = [
            'paid' => 'bg-green-100 text-green-800',
            'pending' => 'bg-amber-100 text-amber-800',
            'unpaid' => 'bg-amber-100 text-amber-800',
        ];
    @endphp

    <div class="py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.total_hotels') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($hotels->count()) }}</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.total_rooms') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($rooms->count()) }}</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.available_rooms') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-green-700">{{ number_format($availableRoomsCount) }}</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">{{ __('dashboard.unavailable_rooms') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-amber-700">{{ number_format($unavailableRoomsCount) }}</p>
                </div>
            </div>

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('dashboard.hotels') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('dashboard.hotels_subtitle') }}</p>
                    </div>
                </div>

                @if ($hotels->isEmpty())
                    <div class="px-5 py-12 text-center">
                        <h4 class="text-base font-semibold text-gray-900">{{ __('No hotels yet') }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Create a hotel to start building your room inventory.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('dashboard.hotel') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('dashboard.location') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('dashboard.contact') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('dashboard.room_types') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('dashboard.rooms') }}</th>
                                    <th scope="col" class="px-5 py-3 text-right font-semibold text-gray-600">{{ __('dashboard.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($hotels as $hotel)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4">
                                            <div class="font-semibold text-gray-900">{{ $hotel->name }}</div>
                                            <div class="mt-1 max-w-xs truncate text-gray-500">{{ $hotel->address ?: __('No address') }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            {{ collect([$hotel->city, $hotel->country])->filter()->join(', ') ?: __('Not set') }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            <div>{{ $hotel->phone_number ?: __('No phone') }}</div>
                                            <div class="mt-1 text-gray-500">{{ $hotel->email ?: __('No email') }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">{{ number_format($hotel->room_types_count) }}</td>
                                        <td class="px-5 py-4 text-gray-700">{{ number_format($hotel->rooms_count) }}</td>
                                        <td class="px-5 py-4 text-right">
                                            <a href="{{ route('hotels.show', $hotel) }}" class="font-semibold text-indigo-600 hover:text-indigo-800">
                                                {{ __('dashboard.open') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Rooms') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('Room numbers, assigned hotels, room types, floors, and status.') }}</p>
                </div>

                @if ($rooms->isEmpty())
                    <div class="px-5 py-12 text-center">
                        <h4 class="text-base font-semibold text-gray-900">{{ __('No rooms yet') }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Add rooms to a hotel after creating its room types.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Room') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Hotel') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Room Type') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Floor') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($rooms as $room)
                                    @php
                                        $roomType = $room->roomType;
                                        $hotel = $roomType?->hotel;
                                        $statusClass = $statusStyles[$room->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 font-semibold text-gray-900">{{ $room->room_number }}</td>
                                        <td class="px-5 py-4 text-gray-700">
                                            @if ($hotel)
                                                <a href="{{ route('hotels.show', $hotel) }}" class="font-medium text-gray-900 hover:text-indigo-700">
                                                    {{ $hotel->name }}
                                                </a>
                                            @else
                                                <span class="text-gray-500">{{ __('No hotel') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">{{ $roomType?->name ?: __('No type') }}</td>
                                        <td class="px-5 py-4 text-gray-700">{{ $room->floor_number ?? __('Not set') }}</td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                                {{ str_replace('_', ' ', ucfirst($room->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <section class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ __('Booked Rooms') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('All room bookings, including every booking and payment status.') }}</p>
                </div>

                @if ($bookings->isEmpty())
                    <div class="px-5 py-12 text-center">
                        <h4 class="text-base font-semibold text-gray-900">{{ __('No bookings yet') }}</h4>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Bookings will appear here after guests reserve rooms.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Room') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Hotel') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Room Type') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Guest') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Dates') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Booking') }}</th>
                                    <th scope="col" class="px-5 py-3 text-left font-semibold text-gray-600">{{ __('Payment') }}</th>
                                    <th scope="col" class="px-5 py-3 text-right font-semibold text-gray-600">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($bookings as $booking)
                                    @php
                                        $room = $booking->room;
                                        $roomType = $room?->roomType;
                                        $hotel = $roomType?->hotel;
                                        $guest = $booking->user;
                                        $bookingStatusClass = $bookingStatusStyles[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                        $paymentStatus = $booking->payment_status ?: 'pending';
                                        $paymentStatusClass = $paymentStatusStyles[$paymentStatus] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 font-semibold text-gray-900">
                                            {{ $room?->room_number ?: __('Room deleted') }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            @if ($hotel)
                                                <a href="{{ route('hotels.show', $hotel) }}" class="font-medium text-gray-900 hover:text-indigo-700">
                                                    {{ $hotel->name }}
                                                </a>
                                            @else
                                                <span class="text-gray-500">{{ __('No hotel') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">{{ $roomType?->name ?: __('No type') }}</td>
                                        <td class="px-5 py-4 text-gray-700">
                                            <div class="font-medium text-gray-900">{{ $guest?->name ?: __('No guest') }}</div>
                                            <div class="mt-1 text-gray-500">{{ $guest?->email ?: __('No email') }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-gray-700">
                                            <div>{{ $booking->check_in?->format('M d, Y') ?: __('No check-in') }}</div>
                                            <div class="mt-1 text-gray-500">{{ $booking->check_out?->format('M d, Y') ?: __('No check-out') }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $bookingStatusClass }}">
                                                {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $paymentStatusClass }}">
                                                {{ str_replace('_', ' ', ucfirst($paymentStatus)) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-right font-semibold text-gray-900">
                                            ${{ number_format((float) $booking->total_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
