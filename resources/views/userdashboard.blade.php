<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-900">
                    {{ __('userdashboard.title') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('userdashboard.subtitle') }}
                </p>
            </div>
            <a href="{{ route('hotels.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                {{ __('userdashboard.view_public_hotels') }}
            </a>
        </div>
    </x-slot>





</x-app-layout>
