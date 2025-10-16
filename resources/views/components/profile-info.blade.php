<div class="mx-auto py-12 px-4]]]=">
    <div class="w-full bg-white dark:bg-gray-900 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm">
        <!-- Profile header -->
        <div class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-8 py-6">
            <div class="flex items-center">
                <div class="relative">
                    @if($user->getMedia('profile_images')->isNotEmpty())
                        <img class="w-24 h-24 rounded-full border-2 border-gray-300 object-cover" 
                             src="{{ $user->getFirstMediaUrl('profile_images') }}" 
                             alt="Profile Image">
                    @else
                        <div class="w-24 h-24 rounded-full border-2 border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-700 dark:text-gray-300 text-3xl font-semibold">{{ strtoupper(substr($user->nickname, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                
                <div class="ml-6">
                    <h2 class="text-gray-900 dark:text-white text-2xl font-semibold mb-1">{{ $user->name }} {{ $user->surname ?? '' }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                        </svg>
                        {{ $user->nickname }}
                    </p>
                </div>
            </div>
        </div>

        <div class="px-8 py-6">
            <!-- Bio section if exists -->
            @if($user->bio)
            <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-gray-700 dark:text-gray-300 text-sm font-semibold uppercase tracking-wide mb-3">{{ __('profile-info.bio') }}</h3>
                <p class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed">{{ $user->bio }}</p>
            </div>
            @endif

            <!-- Profile details -->
            <div class="space-y-6 mb-8">
                <h3 class="text-gray-700 dark:text-gray-300 text-sm font-semibold uppercase tracking-wide">Contact Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">{{ __('profile-info.name') }}</p>
                            <p class="text-gray-900 dark:text-white text-sm font-medium">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">{{ __('profile-info.surname') }}</p>
                            <p class="text-gray-900 dark:text-white text-sm font-medium">{{ $user->surname ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">{{ __('profile-info.email') }}</p>
                            <p class="text-gray-900 dark:text-white text-sm font-medium break-all">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">{{ __('profile-info.phone') }}</p>
                            <p class="text-gray-900 dark:text-white text-sm font-medium">{{ $user->phone }}</p>
                        </div>
                    </div>

                    @if($user->address)
                    <div class="flex items-start md:col-span-2">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wide mb-1">{{ __('profile-info.address') }}</p>
                            <p class="text-gray-900 dark:text-white text-sm font-medium">{{ $user->address }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if (auth()->user()->id !== $user->id)
            <!-- Subscription button -->
            <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-6">
                <form action="{{ route('user.changeSubscription', ['user_id' => $user->id]) }}" method="post">
                    @csrf
                    @if($subscriptionStatus === 'requested')
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Requested
                        </button>
                    @elseif($subscriptionStatus === true)
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-red-300 dark:border-red-700 rounded-lg text-sm font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                            </svg>
                            Unsubscribe
                        </button>
                    @elseif($subscriptionStatus === false)
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            @if($user->is_private)
                                Send Request
                            @else
                            Subscribe
                            @endif
                        </button>
                    @endif
                </form>
                @if($haveAccess === true)
                <form method="POST" action="{{ route('chat.start', ['user' => $user]) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Написати повідомлення
                    </button>
                </form>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>