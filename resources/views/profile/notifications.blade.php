<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.users') }}
        </h2>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Stats -->
            <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Notifications</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Stay updated with your latest activity</p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $notifications->where('is_read', false)->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Unread</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-600 dark:text-gray-300">{{ $notifications->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="space-y-4">
                @forelse ($notifications as $notification)
                    <div class="bg-white dark:bg-gray-800 rounded-xl border {{ $notification->is_read ? 'border-gray-200 dark:border-gray-700' : 'border-blue-300 dark:border-blue-700 shadow-sm shadow-blue-500/10' }} overflow-hidden transition-all duration-200 hover:shadow-md">
                        <div class="p-5">
                            <div class="flex items-start justify-between">
                                <!-- Notification Icon -->
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full {{ $notification->is_read ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gradient-to-br from-blue-500 to-purple-600' }} flex items-center justify-center shadow-sm">
                                            @if($notification->is_read)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Notification Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between mb-2">
                                            <h3 class="text-base font-semibold text-gray-900 dark:text-white pr-4">
                                                {{ $notification->topic }}
                                            </h3>
                                            @if(!$notification->is_read)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 flex-shrink-0">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 leading-relaxed">
                                            {{ $notification->message }}
                                        </p>

                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>

                                            <!-- Action Button -->
                                            <div>
                                                @if ($notification->is_read)
                                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Read
                                                    </span>
                                                @else
                                                    <form action="{{ route('profile.notification.read', $notification->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('patch')
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Mark as Read
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Read Indicator Bar -->
                        @if(!$notification->is_read)
                            <div class="h-1 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                        @endif
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No notifications</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                            You're all caught up! New notifications will appear here when you have updates.
                        </p>
                    </div>
                @endforelse
            </div>

{{--            <!-- Mark All as Read (if there are unread notifications) -->--}}
{{--            @if($notifications->where('is_read', false)->count() > 0)--}}
{{--                <div class="mt-6 text-center">--}}
{{--                    <form action="{{ route('profile.notification.read') }}" method="POST" class="inline">--}}
{{--                        @csrf--}}
{{--                        @method('patch')--}}
{{--                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg font-semibold text-sm transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 shadow-sm">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                            </svg>--}}
{{--                            Mark All as Read--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>
</x-app-layout>