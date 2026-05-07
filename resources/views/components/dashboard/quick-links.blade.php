<section class="mb-8">
    <h2 class="mb-4 text-xl font-semibold text-gray-900">Quick Links</h2>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
        <a href="{{ route('my.bookings') }}" class="flex items-center rounded-md border border-gray-200 bg-white p-4 hover:bg-gray-50">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
            <span class="ml-2 text-gray-800">My Bookings</span>
        </a>
        <a href="#" class="flex items-center rounded-md border border-gray-200 bg-white p-4 hover:bg-gray-50">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="ml-2 text-gray-800">Favorites</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="flex items-center rounded-md border border-gray-200 bg-white p-4 hover:bg-gray-50">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 20v-2a4 4 0 014-4h4a4 4 0 014 4v2"></path></svg>
            <span class="ml-2 text-gray-800">Account Settings</span>
        </a>
    </div>
</section>