<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.publications') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
            <!-- Filter & Sort Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6 transition-colors duration-200">
                
                <!-- Sort Options -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">
                        Sort By
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('publications.sort', ['parameter' => 'likes ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'likes ASC' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'likes ASC' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.likesHigh-low') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'likes DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'likes DESC' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'likes DESC' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('filters.likesLow-high') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'newest', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('filters.newest') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'oldest', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'oldest' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'oldest' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('filters.oldest') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'reposts ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'reposts ASC' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'reposts ASC' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.repostsLow-high') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'reposts DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'reposts DESC' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'reposts DESC' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('filters.repostsHigh-low') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'comments ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'comments ASC' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'comments ASC' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('filters.commentsHigh-low') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'comments DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="group px-4 py-2.5 {{ request()->get('parameter') === 'comments DESC' ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md shadow-blue-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('parameter') === 'comments DESC' ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.commentsLow-high') }}
                        </a>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

                <!-- Search Bar -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">
                        Search
                    </h3>
                    <form action="{{ route('publications.sort') }}" method="get" class="flex items-center">
                        <input type="hidden" name="filter" value="{{ request()->get('filter') ?? ''}}">
                        <input type="hidden" name="parameter" value="{{ request()->get('parameter') ?? ''}}">
                        <div class="relative flex-1 max-w-lg">
                            <input type="text"
                                   name="search"
                                   value="{{ request()->get('search') ?? ''}}"
                                   placeholder="{{ __('filters.searchPublications') }}"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 transition-all duration-200">
                            <button type="submit"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-gray-700 my-6"></div>

                <!-- Filter Options -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">
                        Filter
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('publications.sort', ['filter' => 'subscriptions', 'parameter' => request()->get('parameter'), 'search' => request()->get('search')]) }}"
                           class="group px-5 py-2.5 {{ request()->get('filter') ? 'bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-md shadow-purple-500/30' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-600' }} rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 {{ request()->get('filter') ? '' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('filters.subscriptions') }}
                        </a>

                        <a href="{{ route('publications.sort', ['filter' => null, 'parameter' => null, 'search' => null]) }}"
                           class="group px-5 py-2.5 bg-gray-50 hover:bg-red-50 text-gray-700 hover:text-red-600 dark:bg-gray-700/50 dark:text-gray-300 dark:hover:bg-red-900/20 dark:hover:text-red-400 border border-gray-200 dark:border-gray-600 dark:hover:border-red-800 rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400 dark:text-gray-500 group-hover:text-red-600 dark:group-hover:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            {{ __('filters.reset') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Publications Content -->
            <div class=" rounded-xl shadow-sm overflow-hidden transition-colors duration-200">
                @include('components.publication')
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $publications->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>