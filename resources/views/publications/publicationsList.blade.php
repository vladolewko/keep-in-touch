<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.publications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-5">

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Sort by:</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('publications.sort', ['parameter' => 'likes ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'likes ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.likesHigh-low') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'likes DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'likes DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('filters.likesLow-high') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'newest', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('filters.newest') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'oldest', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'oldest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('filters.oldest') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'reposts ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'reposts ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.repostsLow-high') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'reposts DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'reposts DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('filters.repostsHigh-low') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'comments ASC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'comments ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('filters.commentsHigh-low') }}
                        </a>

                        <a href="{{ route('publications.sort', ['parameter' => 'comments DESC', 'filter' => request()->get('filter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('parameter') === 'comments DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.commentsLow-high') }}
                        </a>
                    </div>
                </div>


                <div class="mb-6">
                    <form action="{{ route('publications.sort') }}"
                          method="get"
                          class="flex items-center">
                        <input type="hidden" name="filter" value="{{ request()->get('filter') ?? ''}}">
                         <input type="hidden" name="parameter" value="{{ request()->get('parameter') ?? ''}}">
                        <input type="text"
                               name="search"
                               value="{{ request()->get('search') ?? ''}}"
                               placeholder="{{ __('filters.searchPublications') }}"
                               class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 w-64">
                        <button type="submit"
                                class="px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-r-md border border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="mb-6">
                    <div class="flex flex-wrap justify-between gap-2">
                        <a href="{{ route('publications.sort', ['filter' => 'subscriptions', 'parameter' => request()->get('parameter'), 'search' => request()->get('search')]) }}"
                           class="px-4 py-2 {{ request()->get('filter') ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.subscriptions') }}
                        </a>

                        <a href="{{ route('publications.sort', ['filter' => null, 'parameter' => null, 'search' => null]) }}"
                           class="px-4 py-2 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                            {{ __('filters.reset') }}
                        </a>
                    </div>
                </div>

            </div>
                @include('components.publication')

            <div class="mt-3.5">
                {{ $publications->withQueryString()->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>

    </div>
</x-app-layout>
