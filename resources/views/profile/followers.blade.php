<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('navigation.followers') }}
        </h2>
    </x-slot>

    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Follow Requests Section -->
            @if($requests->isNotEmpty())
                <div class="bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                    <div class="p-8">
                        <!-- Section Header -->
                        <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-center">
                                <div class="p-3 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl shadow-lg shadow-yellow-500/30 mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                        Follow Requests
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        {{ count($requests) }} {{ count($requests) === 1 ? 'person wants' : 'people want' }} to follow you
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Requests List -->
                        <div class="space-y-4">
                            @foreach($requests as $user)
                                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/10 dark:to-orange-900/10 rounded-2xl overflow-hidden border-2 border-yellow-200 dark:border-yellow-800/50 shadow-lg hover:shadow-xl transition-all duration-300">
                                    <!-- Profile header -->
                                    <div class="p-6 border-b border-yellow-200 dark:border-yellow-800/50">
                                        <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="flex items-center group">
                                            <div class="relative">
                                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-500 to-orange-600 mr-4 flex items-center justify-center ring-4 ring-yellow-500/20 dark:ring-yellow-400/20 group-hover:ring-yellow-500/40 dark:group-hover:ring-yellow-400/40 transition-all duration-300 shadow-lg">
                                                    @if($user->getMedia('profile_images')->isNotEmpty())
                                                        <img class="w-16 h-16 rounded-full object-cover"
                                                             src="{{ $user->getFirstMediaUrl('profile_images') }}"
                                                             alt="Profile Image">
                                                    @else
                                                        <span class="text-white text-xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    @endif
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-yellow-500 rounded-full border-4 border-white dark:border-gray-800 animate-pulse"></div>
                                            </div>
                                            <div>
                                                <h2 class="text-gray-900 dark:text-white text-xl font-bold group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors duration-200">{{ $user->nickname }}</h2>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->name }} {{ $user->surname ?? '' }}</p>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Profile details -->
                                    <div class="p-6 space-y-3 bg-white/50 dark:bg-gray-900/20">
                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ __('profile-info.name') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1 font-medium">{{ $user->name }}</div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ __('profile-info.surname') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1 font-medium">{{ $user->surname ?? '-' }}</div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                </svg>
                                                {{ __('profile-info.nickname') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1 font-medium">{{ $user->nickname }}</div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                                </svg>
                                                {{ __('profile-info.bio') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1">{{ $user->bio ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="p-6 bg-gray-50 dark:bg-gray-900/30 border-t border-yellow-200 dark:border-yellow-800/50">
                                        <form action="{{ route('user.manageSubscriptions', ['subscriber_id' => $user->id]) }}" method="post" class="flex gap-3">
                                            @csrf
                                            @method('patch')

                                            <button type="submit" name="action" value="accept" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-semibold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 transition-all duration-200 flex items-center justify-center hover:scale-105">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                {{ __('buttons.accept') }}
                                            </button>

                                            <button type="submit" name="action" value="decline" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 transition-all duration-200 flex items-center justify-center hover:scale-105">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                {{ __('buttons.decline') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Followers Section -->
            <div class="bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-8">
                    <!-- Section Header -->
                    <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-center">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg shadow-blue-500/30 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ __('navigation.followers') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ count($followers) }} {{ count($followers) === 1 ? 'follower' : 'followers' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($followers->isNotEmpty())
                        <!-- Followers List -->
                        <div class="space-y-4">
                            @foreach($followers as $user)
                                <div class="bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.01]">
                                    <!-- Profile header -->
                                    <div class="p-6 border-b border-gray-200 dark:border-gray-700/50">
                                        <a href="{{ route('users.profile', ['id' => $user->id]) }}" class="flex items-center group">
                                            <div class="relative">
                                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 mr-4 flex items-center justify-center ring-4 ring-blue-500/20 dark:ring-blue-400/20 group-hover:ring-blue-500/40 dark:group-hover:ring-blue-400/40 transition-all duration-300">
                                                    @if($user->getMedia('profile_images')->isNotEmpty())
                                                        <img class="w-16 h-16 rounded-full object-cover"
                                                             src="{{ $user->getFirstMediaUrl('profile_images') }}"
                                                             alt="Profile Image">
                                                    @else
                                                        <span class="text-white text-xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    @endif
                                                </div>
                                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-4 border-white dark:border-gray-800"></div>
                                            </div>
                                            <div>
                                                <h2 class="text-gray-900 dark:text-white text-xl font-bold group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">{{ $user->nickname }}</h2>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->name }} {{ $user->surname ?? '' }}</p>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Profile details -->
                                    <div class="p-6 space-y-3 bg-gray-50/50 dark:bg-gray-900/20">
                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ __('profile-info.name') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1 font-medium">{{ $user->name }}</div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ __('profile-info.surname') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1 font-medium">{{ $user->surname ?? '-' }}</div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                </svg>
                                                {{ __('profile-info.nickname') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1 font-medium">{{ $user->nickname }}</div>
                                        </div>

                                        <div class="flex items-start">
                                            <div class="w-32 text-gray-600 dark:text-gray-400 font-semibold text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                                </svg>
                                                {{ __('profile-info.bio') }}
                                            </div>
                                            <div class="text-gray-900 dark:text-gray-100 text-sm flex-1">{{ $user->bio ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="p-6 bg-gray-50 dark:bg-gray-900/30 border-t border-gray-200 dark:border-gray-700/50">
                                        <form action="{{ route('user.manageSubscriptions', ['subscriber_id' => $user->id]) }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" name="action" value="decline" class="w-full px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 transition-all duration-200 flex items-center justify-center hover:scale-105">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                {{ __('buttons.remove') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-700/50 rounded-full mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">No followers yet</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">When people follow you, they'll appear here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>