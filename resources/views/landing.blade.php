
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'BookingPal') }} - Find great deals</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/" class="text-2xl font-bold text-indigo-600">BookingPal</a>
                <nav class="hidden sm:flex items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                    <a href="#" class="hover:underline">Stays</a>
                    <a href="#" class="hover:underline">Flights</a>
                    <a href="#" class="hover:underline">Cars</a>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <span class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300 font-medium">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-indigo-600 hover:text-indigo-700 font-medium">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition">Sign up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </header>

        <!-- Hero + prominent search -->
        <section class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-12 lg:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight">Find great deals on hotels, homes and much more</h1>
                    <p class="mt-3 text-lg text-indigo-100">Compare prices from top travel sites and pick the best option for your stay.</p>
                </div>

                <!-- Search card (Booking-like) -->
                <div class="max-w-3xl mx-auto">
                    <form action="{{ url()->current() }}" method="GET" class="bg-white text-gray-800 rounded-2xl p-6 shadow-2xl">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                                <input name="city" type="text" value="{{ request('city', $city ?? 'Dubai') }}" placeholder="Where are you going?" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Check-in</label>
                                <input name="check_in" type="date" value="{{ request('check_in') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Check-out</label>
                                <input name="check_out" type="date" value="{{ request('check_out') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-6 py-3 font-semibold text-lg transition">Search</button>

                        @if(request()->filled('city') || request()->filled('check_in') || request()->filled('check_out'))
                            <div class="mt-3 text-center">
                                <a href="{{ url()->current() }}" class="text-sm text-indigo-600 hover:underline">Clear filters</a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Filter chips (Trivago-like) -->
                <div class="max-w-3xl mx-auto mt-6 flex flex-wrap justify-center gap-2">
                    <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-full text-sm font-medium transition">Price</button>
                    <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-full text-sm font-medium transition">Rating</button>
                    <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-full text-sm font-medium transition">Deals</button>
                    <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-full text-sm font-medium transition">Distance</button>
                </div>
            </div>
        </section>

        <!-- Main content: list + sidebar summary like Trivago comparison -->
        <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <section class="lg:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold">Hotels</h2>
                        @foreach($hotels as $hotel)
                        <a href="{{ route('hotels.show', $hotel) }}" class="block hover:underline">
                                    <p class="text-sm text-gray-500">{{ $hotel->name}}, {{ $hotel->country}}</p>
                                </a>
                        @endforeach
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select class="border rounded-md px-2 py-1 text-sm">
                            <option>Recommended</option>
                            <option>Price (low to high)</option>
                            <option>Price (high to low)</option>
                            <option>Rating</option>
                        </select>
                    </div>
                </div>

                @if($hotels->isEmpty())
                    <div class="mt-6 rounded-xl border bg-white p-8 text-center">
                        <p class="text-gray-700 font-medium">No hotels found.</p>
                        <p class="text-gray-500 text-sm mt-1">Try searching with a different city.</p>
                    </div>
                @else
                   

                    <div class="mt-8">
                        <!-- pagination placeholder -->
                        <!-- {{ $hotels->links() }} -->
                    </div>
                @endif
            </section>

            <!-- Sidebar: Price comparison / deals like Trivago -->
            <aside class="bg-white rounded-xl p-4 shadow-sm">
                <h3 class="text-sm font-semibold">Best deals</h3>
                <p class="text-xs text-gray-500 mt-1">Prices aggregated from multiple partners</p>

                <!-- <ul class="mt-4 space-y-4">
                    @foreach($hotels->take(4) as $hotel)
                        <li class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium">{{ $hotel->name }}</div>
                                <div class="text-xs text-gray-500">{{ $hotel->city ?? '—' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 line-through">${{ number_format((($hotel->price ?? 120) * 1.2)) }}</div>
                                <div class="text-lg font-bold text-indigo-600">${{ number_format($hotel->price ?? 99) }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul> -->

                <div class="mt-6 text-center">
                    <a href="#" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md">See all deals</a>
                </div>
            </aside>
        </main>

        <footer class="border-t bg-white dark:bg-gray-800 dark:border-gray-700 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-gray-600 dark:text-gray-300 flex flex-col sm:flex-row justify-between gap-4">
                <div>
                    © {{ date('Y') }} BookingPal
                </div>
                <div class="flex gap-4">
                    <a href="#" class="hover:underline">Help</a>
                    <a href="#" class="hover:underline">Privacy</a>
                    <a href="#" class="hover:underline">Terms</a>
                </div>
            </div>
        </footer>
    </body>
</html>
