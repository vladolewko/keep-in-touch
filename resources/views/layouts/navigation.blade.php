<nav x-data="{ open: false }"
     class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200/50 dark:border-gray-700/50 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <div class="flex items-center">
                    <x-application-logo
                        class="block w-10 h-10 text-gray-800 dark:text-gray-200 transition-transform hover:scale-110 duration-300"/>
                </div>

                <div class="hidden space-x-1 lg:flex items-center">
                    <x-nav-link :href="route('publications')"
                                :active="request()->routeIs('publications')"
                                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        {{ __('navigation.publications') }}
                    </x-nav-link>

                    <x-nav-link :href="route('users')"
                                :active="request()->routeIs('users')"
                                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        {{ __('navigation.users') }}
                    </x-nav-link>

                    <x-nav-link :href="route('profile.followers')"
                                :active="request()->routeIs('profile.followers')"
                                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        {{ __('navigation.followers') }}
                    </x-nav-link>

                    <x-nav-link :href="route('profile.subscriptions')"
                                :active="request()->routeIs('profile.subscriptions')"
                                class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        {{ __('navigation.subscriptions') }}
                    </x-nav-link>

                    <x-nav-link :href="route('profile.notifications')"
                                :active="request()->routeIs('profile.notifications')"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        <span>{{ __('navigation.notifications') }}</span>
                        @if (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span id="unread-notifications-badge"
                                  class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </x-nav-link>

                    <x-nav-link :href="route('chats.index')"
                                :active="request()->routeIs('chats.index')"
                                class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                        <span>{{ __('navigation.chats') }}</span>
                        @if (isset($totalUnreadCount) && $totalUnreadCount > 0)
                            <span id="total-unread-badge"
                                  class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ $totalUnreadCount }}
                            </span>
                        @endif
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:gap-3">
                <form
                    action="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), request()->route()->parameters()) }}"
                    method="get">

                    <select
                        class="appearance-none pl-3 pr-8 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-no-repeat bg-right-2 bg-[url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e&quot;)]"
                        name="lang"
                        onchange="this.form.submit()">
                        @foreach(config('app.available_locales') as $locale)
                            <option
                                value="{{ $locale }}" {{ app()->getLocale() == $locale ? 'selected' : '' }}>{{ strtoupper($locale) }}</option>
                        @endforeach
                    </select>
                    </form>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center transition-transform hover:scale-105 duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded-full">
                            @if(auth()->user()->getMedia('profile_images')->isNotEmpty())
                                <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
                                     src="{{ auth()->user()->getFirstMediaUrl('profile_images') }}"
                                     alt="Profile">
                            @else
                                <span
                                    class="flex items-center justify-center w-10 h-10 text-white text-sm font-semibold bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full shadow-md">
                                    {{ strtoupper(Auth::user()->name[0]) }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link href="{{ route('profile') }}"
                                         class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-4 h-4"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('navigation.profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')"
                                         class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-4 h-4"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ __('navigation.settings') }}
                        </x-dropdown-link>

                        <form method="POST"
                              action="{{ route('logout') }}"
                              class="border-t border-gray-100 dark:border-gray-700 mt-1 pt-1">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();"
                                             class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-4 h-4"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                {{ __('navigation.logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center lg:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200">
                    <svg class="h-6 w-6"
                         stroke="currentColor"
                         fill="none"
                         viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden lg:hidden border-t border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('publications')"
                                   :active="request()->routeIs('publications')"
                                   class="block px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                {{ __('navigation.publications') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('users')"
                                   :active="request()->routeIs('users')"
                                   class="block px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                {{ __('navigation.users') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.followers')"
                                   :active="request()->routeIs('profile.followers')"
                                   class="block px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                {{ __('navigation.followers') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.subscriptions')"
                                   :active="request()->routeIs('profile.subscriptions')"
                                   class="block px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                {{ __('navigation.subscriptions') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('profile.notifications')"
                                   :active="request()->routeIs('profile.notifications')"
                                   class="flex items-center justify-between px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span>{{ __('navigation.notifications') }}</span>
                @if (isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                    <span id="unread-notifications-badge-mobile"
                          class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $unreadNotificationsCount }}
                    </span>
                @endif
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('chats.index')"
                                   :active="request()->routeIs('chats.index')"
                                   class="flex items-center justify-between px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span>{{ __('Чати') }}</span>
                @if (isset($totalUnreadCount) && $totalUnreadCount > 0)
                    <span id="total-unread-badge-mobile"
                          class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $totalUnreadCount }}
                    </span>
                @endif
            </x-responsive-nav-link>

            <div class="px-0 pt-2">
                <form
                    action="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), request()->route()->parameters()) }}"
                    method="get">

                    <select
                        class="w-full appearance-none pl-3 pr-8 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg text-base font-medium focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-no-repeat bg-right-2 bg-[url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e&quot;)]"
                        name="lang"
                        onchange="this.form.submit()">
                        @foreach(config('app.available_locales') as $locale)
                            <option
                                value="{{ $locale }}" {{ app()->getLocale() == $locale ? 'selected' : '' }}>{{ strtoupper($locale) }}</option>
                        @endforeach
                    </select>
                    </form>
            </div>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4 mb-3">
                <div class="flex items-center gap-3">
                    @if(auth()->user()->getMedia('profile_images')->isNotEmpty())
                        <img class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
                             src="{{ auth()->user()->getFirstMediaUrl('profile_images') }}"
                             alt="Profile">
                    @else
                        <span
                            class="flex items-center justify-center w-12 h-12 text-white text-lg font-semibold bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full shadow-md">
                            {{ strtoupper(Auth::user()->name[0]) }}
                        </span>
                    @endif
                    <div>
                        <div class="font-medium text-base text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile')"
                                       class="block px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    {{ __('navigation.profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')"
                                       class="block px-4 py-2.5 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    {{ __('navigation.settings') }}
                </x-responsive-nav-link>

                <form method="POST"
                      action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="block px-4 py-2.5 rounded-lg text-base font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        {{ __('navigation.logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
