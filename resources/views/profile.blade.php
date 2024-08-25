<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="max-w-7xl mx-auto p-4">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{asset('storage/' .auth()->user()->profile_photo_path)}}" alt="Profile  photo" class="rounded-full h-16 w-16 object-cover">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Photo" class="rounded-full w-16 h-16">
                @endif
                <h2 class="text-lg font-semibold mb-4">Profile</h2>
                @livewire('profile-photo')
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
