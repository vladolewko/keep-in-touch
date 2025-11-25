<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <!-- {{ __('Мої чати') }} -->
            {{ __('chat.index.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">

                        @forelse ($conversations as $conversation)
                            <div class="relative">

                                <a href="{{ route('chat.show', $conversation) }}"
                                   class="block p-4 transition duration-150 ease-in-out {{ $conversation->unread_messages_count > 0 ? 'bg-blue-50 dark:bg-gray-700' : '' }} hover:bg-gray-100 dark:hover:bg-gray-700">

                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <img class="h-12 w-12 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ optional($conversation->participants->first())->nickname }}&background=random"
                                                alt="Avatar">
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="truncate text-md {{ $conversation->unread_messages_count > 0 ? 'font-bold' : 'font-semibold' }}">
                                                {{ optional($conversation->participants->first())->nickname }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                @if ($conversation->lastMessage)
                                                    {{ $conversation->lastMessage->body }}
                                                @else
                                                    <span class="italic">{{ __('chat.index.no_messages_yet') }}</span>
                                                @endif
                                            </p>
                                        </div>

                                        <div class="flex flex-col items-end space-y-2 self-start">
                                            @if ($conversation->lastMessage)
                                                <div class="text-xs text-gray-400 whitespace-nowrap">
                                                    {{ $conversation->lastMessage->created_at->diffForHumans() }}
                                                </div>
                                            @endif

                                            @if ($conversation->unread_messages_count > 0)
                                                <div class="bg-red-600 dark:bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                                    {{ $conversation->unread_messages_count }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <form action="{{ route('chat.destroy', $conversation) }}"
                                      method="POST"
                                      class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                    @csrf
                                    @method('DELETE')

                                    <div>
                                        <label class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                            <input type="checkbox"
                                                name="for_both"
                                                class="mr-2 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                            {{ __('chat.index.delete_for_all') }}
                                        </label>
                                    </div>

                                    <!-- onclick="return confirm('Ви впевнені, що хочете видалити цей чат?')" -->
                                    <button type="submit"
                                        data-confirm-delete="{{ __('chat.index.confirm_delete') }}"
                                        onclick="return confirm(this.dataset.confirmDelete)"
                                        class="text-xs font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 hover:underline">
                                        <!-- {{ __('Видалити чат') }} -->
                                        {{ __('chat.index.delete_chat') }}
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="p-4 text-center text-gray-500 dark:text-gray-400">
                                <!-- У вас ще немає жодного чату. -->
                                {{ __('chat.index.no_chats_yet') }}
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
