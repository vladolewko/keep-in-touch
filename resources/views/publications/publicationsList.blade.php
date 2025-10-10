<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('navigation.publications') }}
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
                    <a href="{{ route('publications.sort', ['parameter' => 'likes ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'likes ASC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'likes ASC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                        {{ __('filters.likesHigh-low') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'likes DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'likes DESC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'likes DESC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        {{ __('filters.likesLow-high') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'newest', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.newest') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'oldest', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'oldest' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'oldest' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.oldest') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'reposts ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'reposts ASC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'reposts ASC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                        {{ __('filters.repostsLow-high') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'reposts DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'reposts DESC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'reposts DESC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        {{ __('filters.repostsHigh-low') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'comments ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'comments ASC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'comments ASC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        {{ __('filters.commentsHigh-low') }}
                    </a>

                    <a href="{{ route('publications.sort', ['parameter' => 'comments DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                       class="group px-5 py-2.5 {{ request()->get('parameter') === 'comments DESC' ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'comments DESC' ? 'text-white' : 'text-blue-500 dark:text-blue-400 group-hover:text-blue-600 dark:group-hover:text-blue-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                        {{ __('filters.commentsLow-high') }}
                    </a>
                </div>
            </div>

            <!-- Search Section -->
            <div class="mb-8 bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search Publications
                </h3>
                <form action="{{ route('publications.sort') }}" method="get" class="flex items-center">
                    <input type="hidden" name="filter" value="{{ request()->get('filter') ?? ''}}">
                    <input type="hidden" name="parameter" value="{{ request()->get('parameter') ?? ''}}">
                    <div class="relative flex-1 max-w-2xl">
                        <input type="text"
                               name="search"
                               value="{{ request()->get('search') ?? ''}}"
                               placeholder="{{ __('filters.searchPublications') }}"
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

            <!-- Filter Actions Section -->
            <div class="mb-8 bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <a href="{{ route('publications.sort', ['filter' => 'subscriptions', 'parameter' => request()->get('parameter'), 'search' => request()->get('search')]) }}"
                       class="group px-6 py-3 {{ request()->get('filter') ? 'bg-gradient-to-r from-purple-600 to-purple-500 text-white shadow-lg shadow-purple-500/30' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700/70 dark:hover:bg-gray-600/70 text-gray-700 dark:text-gray-300' }} rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 {{ request()->get('filter') ? 'text-white' : 'text-purple-500 dark:text-purple-400 group-hover:text-purple-600 dark:group-hover:text-purple-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('filters.subscriptions') }}
                    </a>

                    <a href="{{ route('publications.sort', ['filter' => null, 'parameter' => null, 'search' => null]) }}"
                       class="group px-6 py-3 bg-gray-100 hover:bg-red-500 dark:bg-gray-700/70 dark:hover:bg-red-600/80 text-gray-700 hover:text-white dark:text-gray-300 dark:hover:text-white rounded-xl text-sm font-medium transition-all duration-200 flex items-center hover:scale-105 hover:shadow-lg border border-gray-200 dark:border-gray-600/50 hover:border-red-400 dark:hover:border-red-500/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500 dark:text-red-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('filters.reset') }}
                    </a>
                </div>
            </div>

            <!-- Publications Content -->
            <div class="bg-white/60 dark:bg-gray-800/30 backdrop-blur-sm rounded-2xl p-6 shadow-xl dark:shadow-2xl border border-gray-200/50 dark:border-gray-700/50">
                @include('components.publication')
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $publications->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>