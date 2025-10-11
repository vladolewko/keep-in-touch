<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.subscriptions') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subscriptions as $user)
                    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Profile Header with Background -->
                        <div class="relative h-24 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                            <div class="absolute -bottom-12 left-6">
                                <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="block">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center ring-4 ring-white dark:ring-gray-800 shadow-lg overflow-hidden transition-transform duration-200 hover:scale-105">
                                        @if($user->getMedia('profile_images')->isNotEmpty())
                                            <img class="w-full h-full object-cover"
                                                 src="{{ $user->getFirstMediaUrl('profile_images') }}"
                                                 alt="Profile Image">
                                        @else
                                            <span class="text-white text-2xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Profile Content -->
                        <div class="pt-16 px-6 pb-6">
                            <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="block mb-4 group">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $user->nickname }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $user->name }} {{ $user->surname ?? '' }}
                                </p>
                            </a>

                            <!-- Profile Details -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-start">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 mr-3 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Name</p>
                                        <p class="text-sm text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    </div>
                                </div>

                                @if($user->surname)
                                    <div class="flex items-start">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 mr-3 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Surname</p>
                                            <p class="text-sm text-gray-900 dark:text-white truncate">{{ $user->surname }}</p>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex items-start">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 mr-3 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Nickname</p>
                                        <p class="text-sm text-gray-900 dark:text-white truncate">{{ $user->nickname }}</p>
                                    </div>
                                </div>

                                @if($user->bio)
                                    <div class="flex items-start">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 mr-3 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Bio</p>
                                            <p class="text-sm text-gray-900 dark:text-white line-clamp-2">{{ $user->bio }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Button -->
                            <form action="{{ route('user.changeSubscription', ['user_id' => $user->id]) }}" method="post">
                                @csrf
                                @if($user->subscription_status === 'requested')
                                    <button type="submit" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold text-sm transition-all duration-200 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ __('buttons.requested') }}
                                    </button>
                                @elseif($user->subscription_status === true)
                                    <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center justify-center group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        {{ __('buttons.unsubscribe') }}
                                    </button>
                                @elseif($user->subscription_status === false)
                                    <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center justify-center group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        {{ __('buttons.subscribe') }}
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($subscriptions->isEmpty())
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No subscriptions yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                        Start following people to see their content and updates here.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>