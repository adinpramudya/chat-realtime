<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 ">
                    <h1 class="text-2xl font-bold">Contact List</h1>
                    <ul class="mt-5">
                        @foreach ($users as $user)
                            @if($user->latestMessage != null)
                            <div
                                class="w-full max-w-[1120px] mx-6 rounded-lg px-6 py-4 mb-4 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 dark:from-blue-600 dark:via-blue-700 dark:to-blue-800 shadow-2xl transform scale-105 transition-transform duration-300 ease-in-out">
                                <div class="flex items-center">
                                    @if($user->profile_photo_path)
                                        <img alt="Profile Photo" class="w-16 h-16 rounded-full object-cover"
                                             src="{{asset('storage/' .$user->profile_photo_path)}}"/>
                                    @else
                                        <img alt="Default Photo" class="w-16 h-16 rounded-full"
                                             src="{{asset('images/default-profile.png')}}"/>
                                    @endif

                                        <div class="relative w-full">
                                            <a wire:navigate class="text-white dark:text-gray-200 ml-3 font-bold"
                                               href="{{ route('chat', $user) }}">{{ $user->name }}</a>
                                            @if ($user->latestMessage->status == 'pending')
                                                <div class="flex items-center mt-1 mr-1 ml-2"><i class="material-icons">schedule</i>Pending
                                                    <span>{{ $user->latestMessage->message}}</span></div>
                                            @elseif ($user->latestMessage->status == 'sent')
                                                <div class="flex items-center mt-1">
                                                    <div
                                                        class="bg-blue-900 w-5 h-5 rounded-full text-sm flex items-center justify-center mr-1 ml-2">
                                                        D
                                                    </div>
                                                    <span>{{ $user->latestMessage->message}}</span>
                                                </div>
                                            @elseif ($user->latestMessage->status == 'read')
                                                <div class="flex items-center mt-1">
                                                    <div
                                                        class="bg-green-900 w-5 h-5 rounded-full text-sm flex items-center justify-center mr-1 ml-2">
                                                        R
                                                    </div>
                                                    <span>{{ $user->latestMessage->message}}</span>
                                                </div>
                                            @endif

                                            <span class="absolute right-0 top-0">{{$user->latestMessage->formatted_date }}</span>
                                        </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
