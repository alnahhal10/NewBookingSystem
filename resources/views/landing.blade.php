<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BookingPal') }} - Find great deals</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    {{-- ===== HEADER ===== --}}
    <header x-data="{ open: false }" class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="/" class="text-xl font-bold text-indigo-600 tracking-tight">BookingPal</a>
                <nav class="hidden sm:flex items-center gap-1 text-sm">
                    <a href="#" class="px-3 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition">Stays</a>
                    <a href="#" class="px-3 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition">Flights</a>
                    <a href="#" class="px-3 py-1.5 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition">Cars</a>
                    @auth
                        @role('admin')
                            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 font-medium transition">{{ __('navigation.dashboard') }}</a>
                        @endrole
                    @endauth
                </nav>
            </div>

            <div class="flex items-center gap-2">
                <!-- Mobile hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ open: false }">
                <!-- زر القائمة -->
                <button @click="open = ! open" 
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    
                    {{-- عرض اسم اللغة الحالية --}}
                    {{ LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['native'] }}
                    
                    <!-- أيقونة السهم لأسفل -->
                    <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

             <!-- القائمة المنسدلة -->
                <div x-show="open" 
                    @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    
                    <ul class="py-1">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                                class="block px-4 py-2 text-sm {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                    
                                    {{-- يمكنك إضافة علم صغير هنا إذا أردت --}}
                                    {{ $properties['native'] }}
                                    
                                    {{-- علامة صح للغة الحالية --}}
                                    @if(LaravelLocalization::getCurrentLocale() == $localeCode)
                                        <span class="float-right text-green-500">✓</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>







                @if(Route::has('login'))
                    @auth
                        <span class="text-sm text-gray-600 dark:text-gray-300 font-medium hidden sm:block">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium transition dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400">
                               {{ __('navigation.logout') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium transition dark:text-gray-300">{{ __('navigation.log in') }}</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition shadow-sm">{{ __('navigation.Sign up') }}</a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    @if(Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                                Log in
                            </a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 dark:text-indigo-400 dark:hover:bg-indigo-900/30 transition">
                                    Sign up
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ===== HERO ===== --}}
<section class="bg-gradient-to-br from-indigo-600 via-indigo-500 to-blue-500 text-white py-14 lg:py-20"
    style="background-image: url('/hotel_images/hero-bg.jpg'); 
    background-size: cover; background-position: center; background-repeat: no-repeat;">
    
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight tracking-tight">
                    Find great deals on hotels,<br class="hidden sm:block"> homes and much more
                </h1>
                <p class="mt-4 text-lg text-indigo-100 max-w-xl mx-auto">Compare prices from top travel sites and pick the best option for your stay.</p>
            </div>

            {{-- Search card --}}
            <div class="max-w-3xl mx-auto">
                <form action="{{ url()->current() }}" method="GET" class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Destination</label>
                            <input name="city" type="text" value="{{ request('city', $city ?? '') }}" placeholder="Where are you going?"
                                class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Check-in</label>
                            <input name="check_in" type="date" value="{{ request('check_in') }}"
                                class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Check-out</label>
                            <input name="check_out" type="date" value="{{ request('check_out') }}"
                                class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white rounded-xl px-6 py-3 font-semibold text-base transition shadow-md">
                        Search Hotels
                    </button>
                    @if(request()->filled('city') || request()->filled('check_in') || request()->filled('check_out'))
                        <div class="mt-3 text-center">
                            <a href="{{ url()->current() }}" class="text-sm text-indigo-500 hover:underline">Clear filters</a>
                        </div>
                    @endif
                </form>
            </div>

            {{-- Filter chips --}}
            <div class="max-w-3xl mx-auto mt-5 flex flex-wrap justify-center gap-2">
                @foreach(['Price', 'Rating', 'Deals', 'Distance', 'Free WiFi'] as $filter)
                    <button class="px-4 py-1.5 bg-white/15 hover:bg-white/25 border border-white/20 rounded-full text-sm font-medium transition">
                        {{ $filter }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== MAIN ===== --}}
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- Hotels Section --}}
            <section class="lg:col-span-2">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        Hotels
                        @if($hotels->total() > 0)
                            <span class="text-sm font-normal text-gray-400 ml-1">— {{ $hotels->total() }} results</span>
                        @endif
                    </h2>
                    <select class="text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        <option>Recommended</option>
                        <option>Price (low to high)</option>
                        <option>Price (high to low)</option>
                        <option>Rating</option>
                    </select>
                </div>

                {{-- Empty state --}}
                @if($hotels->isEmpty())
                    <div class="rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-12 text-center">
                        <div class="text-4xl mb-3">🏨</div>
                        <p class="text-gray-700 dark:text-gray-300 font-medium">No hotels found.</p>
                        <p class="text-gray-400 text-sm mt-1">Try searching with a different city or date.</p>
                    </div>

                {{-- Hotel cards --}}
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @foreach($hotels as $hotel)
                        <a href="{{ route('hotels.show', [
        'hotel' => $hotel, 
        'check_in' => request('check_in'), 
        'check_out' => request('check_out')
    ]) }}"
                           class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden hover:border-indigo-300 hover:shadow-lg hover:shadow-indigo-100/50 dark:hover:shadow-none transition-all duration-200 flex flex-col">

                            {{-- Image --}}
                            @php $imgs = json_decode($hotel->images, true); @endphp
                            <div class="relative h-44 bg-gradient-to-br from-blue-100 via-indigo-200 to-indigo-400 dark:from-indigo-900 dark:to-blue-800 flex items-center justify-center overflow-hidden">
                                @if(!empty($imgs))
                                    <img src="{{ $imgs[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $hotel->name }}">
                                @else
                                    <svg class="w-14 h-14 text-white/60 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                        <polyline points="9,22 9,12 15,12 15,22"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Body --}}
                            <div class="p-4 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-base truncate">{{ $hotel->name }}</h3>
                                <div class="flex-shrink-0 ml-3 text-right">
                                    <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">${{ $hotel->min_price }}</span>
                                    <span class="text-xs text-gray-400">/night</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $hotels->links() }}
                    </div>
                @endif
            </section>

            {{-- ===== SIDEBAR ===== --}}
            <aside class="hidden lg:block sticky top-24 space-y-4">

                {{-- Best deals --}}
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">🔥 Best deals</h3>
                        <span class="text-xs text-indigo-500 font-medium">Today only</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-4">Prices from multiple partners</p>
                    <ul class="space-y-3">
                        @foreach($hotels->take(4) as $hotel)
                        <li class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ Str::limit($hotel->name, 18) }}</p>
                                <p class="text-xs text-gray-400">{{ $hotel->city }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs text-gray-300 line-through">${{ number_format(($hotel->price ?? 99) * 1.2) }}</p>
                                <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">${{ $hotel->price ?? 99 }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <a href="#" class="mt-5 block w-full text-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition">
                        See all deals
                    </a>
                </div>

                {{-- Promo card --}}
                <div class="bg-gradient-to-br from-indigo-500 to-blue-500 rounded-2xl p-5 text-white">
                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-100 mb-1">Limited offer</p>
                    <h4 class="text-lg font-bold mb-1">Save up to 30%</h4>
                    <p class="text-sm text-indigo-100 mb-4">Sign up and get exclusive member deals on your first booking.</p>
                    @guest
                        <a href="{{ route('register') }}" class="block w-full text-center py-2 bg-white text-indigo-600 text-sm font-semibold rounded-xl hover:bg-indigo-50 transition">
                            Join for free
                        </a>
                    @endguest
                </div>

            </aside>

        </div>
    </main>
{{-- ===== MAP ===== --}}
<section class="py-12 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            🗺️ Explore the Area
        </h2>
        <div id="map" class="rounded-2xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700"
             style="height: 450px; width: 100%;"></div>
    </div>
</section>

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([31.9, 35.2], 12); // غيّر الموقع هنا

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
</script>
    {{-- ===== FOOTER ===== --}}
    <footer class="border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-indigo-600">BookingPal</span>
                <span>© {{ date('Y') }}</span>
            </div>
            <div class="flex gap-5">
                <a href="#" class="hover:text-gray-900 dark:hover:text-gray-200 transition">Help</a>
                <a href="#" class="hover:text-gray-900 dark:hover:text-gray-200 transition">Privacy</a>
                <a href="#" class="hover:text-gray-900 dark:hover:text-gray-200 transition">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>