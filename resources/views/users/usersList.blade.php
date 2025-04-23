<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Styled Sort Filters -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2">

                    <a href="{{ route('users.sort', ['parameter' => 'name ASC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') == 'name ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.nameA-Z') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'name DESC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'name DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.nameZ-A') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'nickname ASC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') == 'nickname ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.nicknameA-Z') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'nickname DESC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'nickname DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.nicknameZ-A') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'newest', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:text-gray-400 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.newest') }}
                    </a>

                    <a href="{{ route('users.sort', ['parameter' => 'oldest', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'oldest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('filters.oldest') }}
                    </a>

                </div>
            </div>


            <div class="mb-6">
                <form action="{{ route('users.sort') }}"
                      method="get"
                      class="flex items-center">
                    @csrf
                    @method('get')
                    <input type="hidden" name="parameter" value="{{ request()->get('parameter') ?? ''}}">
                    <input type="text"
                           name="search"
                           value="{{ request()->get('search') ?? ''}}"
                           placeholder="{{ __('filters.searchUsers') }}"
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
                <a href="{{ route('users') }}"
                   class="max-w-32 px-4 py-2 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600' rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                    {{ __('filters.reset') }}
                </a>
            </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach($users as $user)
                        <div class="mx-auto mb-5">
                            <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 p-6">
                                <!-- Profile header -->
                                <div class="flex items-center justify-between mb-6 border-b border-gray-700 pb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gray-600 mr-4 flex items-center justify-center">
                                            @if($user->getMedia('profile_images')->isNotEmpty())

                                                <img class="w-16 h-16 rounded-full bg-cover" src="{{ $user->getFirstMediaUrl('profile_images') }}" alt="Publication Image">
                                            @else

                                                <span class="text-white font-semibold">{{ strtoupper(substr($user->nickname, 0, 1)) }}</span>
                                            @endif
                                        </div>
                                        <div>

                                            <h2 class="text-white text-xl font-bold"><a href="{{ route('users.profile', ['id' => $user->id]) }}">{{ $user->nickname }}</a></h2>
                                            <p class="text-gray-400 text-sm">{{ $user->name }} {{ $user->surname ?? '' }}</p>
                                        </div>
                                    </div>
                                    @if($user->subscription_status === 'requested')
                                        <div>
                                            <p class="text-black dark:text-gray-200">Requested</p>
                                        </div>
                                    @elseif($user->subscription_status === true)
                                        <div>
                                            <p class="text-black dark:text-yellow-200">Subscribed</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Profile details -->
                                <div class="space-y-4">
                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.name') }}:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->name }}</div>
                                    </div>

                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.surname') }}:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->surname ?? '-' }}</div>
                                    </div>

                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.nickname') }}:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->nickname }}</div>
                                    </div>


                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.bio') }}:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->bio ?? '-' }}</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            {{ $users->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</x-app-layout>
