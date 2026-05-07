<div class="mb-6">
    <form action="{{ route('hotels.index') }}" method="GET" class="flex">
        <input type="text" name="search" placeholder="Search hotels or rooms..." class="flex-grow rounded-l-md border border-gray-300 bg-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        <button type="submit" class="rounded-r-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Search
        </button>
    </form>
</div>