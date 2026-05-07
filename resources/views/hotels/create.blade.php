<x-app-layout>
<a href="{{url('/')}} " >home</a>

<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl mb-4">Create Hotel</h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hotels.store') }}" method="POST"   enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">image</label>
            <input type="file" name="image" class="w-full border p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium">City</label>
            <input type="text" name="city" value="{{ old('city') }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">country</label>
            <input type="text" name="country" value="{{ old('country') }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">address</label>
            <input type="text" name="address" value="{{ old('address') }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">phone</label>
            <input type="number" name="phone_number" value="{{ old('phone_number') }}" class="w-full border p-2">
        </div>

        <div class="mb-4">
            <label class="block font-medium">email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2">
        </div>

         <div class="mb-4">
            <label class="block font-medium">State</label>
            <input type="text" name="state" value="{{ old('state') }}" class="w-full border p-2">
        </div>

        <!-- <div class="mb-4">
            <label class="block font-medium">Star Rating</label>
            <input type="number" name="star_rating" value="{{ old('star_rating') }}" min="0" max="5" class="w-full border p-2">
        </div> -->
            

        


        <!-- <div class="mb-4">
            <label class="block font-medium">slug</label>
            <textarea name="slug" class="w-full border p-2">{{ old('slug') }}</textarea>
        </div> -->

        <div class="mb-4">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border p-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Create</button>
        </div>
    </form>
</div>

</x-app-layout>
