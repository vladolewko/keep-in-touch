<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('navigation.users') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Sort Filters Section -->
            <div class="mb-8 bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                    </svg>
                    Sort Options
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('users.sort', ['parameter' => 'name ASC', 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') == 'name ASC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') == 'name ASC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                        </svg>
                        {{ __('filters.nameA-Z') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'name DESC', 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'name DESC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'name DESC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                        {{ __('filters.nameZ-A') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'nickname ASC', 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') == 'nickname ASC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') == 'nickname ASC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('filters.nicknameA-Z') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'nickname DESC', 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'nickname DESC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'nickname DESC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('filters.nicknameZ-A') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'newest', 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.newest') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'oldest', 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'oldest' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'oldest' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.oldest') }}
                    </a>
                </div>
            </div>

            <!-- Search Section -->
            <div class="mb-8 bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search Users
                </h3>
                <form action="{{ route('users.sort') }}" method="get" class="flex items-center">
                    <input type="hidden" name="parameter" value="{{ request()->get('parameter') ?? ''}}">
                    <div class="relative flex-1 max-w-2xl">
                        <input type="text"
                               name="search"
                               value="{{ request()->get('search') ?? ''}}"
                               placeholder="{{ __('filters.searchUsers') }}"
                               class="w-full px-5 py-3 bg-gray-50 dark:bg-gray-700/70 border border-gray-300 dark:border-gray-600 rounded-l-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200">
                    </div>
                    <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white rounded-r-xl border-l-0 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Reset Button -->
            <div class="mb-8">
                <a href="{{ route('users') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-red-500 dark:bg-gray-700/70 dark:hover:bg-red-600/80 text-gray-700 hover:text-white dark:text-gray-300 dark:hover:text-white rounded-xl text-sm font-medium transition-all duration-200 hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50 hover:border-red-400 dark:hover:border-red-500/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ __('filters.reset') }}
                </a>
            </div>

            <!-- Users List -->
            <div class="space-y-4">
                @foreach($users as $user)
                    <div class="bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50 shadow-xl dark:shadow-2xl hover:shadow-2xl dark:hover:shadow-3xl transition-all duration-300 hover:scale-[1.02]">
                        <!-- Profile header -->
                        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700/50">
                            <a class="flex items-center flex-1 group" href="{{ route('users.profile', ['id' => $user->id]) }}">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 mr-4 flex items-center justify-center ring-4 ring-blue-500/20 dark:ring-blue-400/20 group-hover:ring-blue-500/40 dark:group-hover:ring-blue-400/40 transition-all duration-300">
                                        @if($user->getMedia('profile_images')->isNotEmpty())
                                            <img class="w-16 h-16 rounded-full object-cover"
                                                 src="{{ $user->getFirstMediaUrl('profile_images') }}"
                                                 alt="Profile Image">
                                        @else
                                            <span class="text-white font-bold text-xl">{{ strtoupper(substr($user->nickname, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-4 border-white dark:border-gray-800"></div>
                                </div>
                                <div>
                                    <h2 class="text-gray-900 dark:text-white text-xl font-bold group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">{{ $user->nickname }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->name }} {{ $user->surname ?? '' }}</p>
                                </div>
                            </a>
                            
                            @if($user->subscription_status === 'requested')
                                <div class="px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 rounded-full text-sm font-semibold border border-yellow-200 dark:border-yellow-800">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Requested
                                </div>
                            @elseif($user->subscription_status === true)
                                <div class="px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm font-semibold border border-green-200 dark:border-green-800">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Subscribed
                                </div>
                            @endif
                        </div>

                        <!-- Profile details -->
                        <div class="p-6 space-y-4 bg-gray-50/50 dark:bg-gray-900/20">
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
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $users->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>