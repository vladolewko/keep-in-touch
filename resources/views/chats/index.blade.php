<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Мої чати') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-2">
                        @forelse ($conversations as $conversation)
                            <div class="p-4 rounded-lg transition duration-150 ease-in-out {{ $conversation->unread_messages_count > 0 ? 'bg-blue-50 dark:bg-gray-700/50' : '' }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('chat.show', $conversation) }}">
                                            <img class="h-12 w-12 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ optional($conversation->participants->first())->nickname }}&background=random"
                                                alt="Avatar">
                                        </a>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('chat.show', $conversation) }}"
                                            class="block">
                                            <p class="truncate {{ $conversation->unread_messages_count > 0 ? 'font-bold' : 'font-semibold' }}">
                                                {{ optional($conversation->participants->first())->nickname }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                @if ($conversation->lastMessage)
                                                    {{ $conversation->lastMessage->body }}
                                                @else
                                                    <span class="italic">Повідомлень ще немає</span>
                                                @endif
                                            </p>
                                        </a>
                                    </div>

                                    <div class="flex flex-col items-end space-y-2 self-start">
                                        @if ($conversation->lastMessage)
                                            <div class="text-xs text-gray-400 whitespace-nowrap">
                                                {{ $conversation->lastMessage->created_at->diffForHumans() }}
                                            </div>
                                        @endif

                                        {{-- НАШ НОВИЙ ЛІЧИЛЬНИК --}}
                                        @if ($conversation->unread_messages_count > 0)
                                            <div class="bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
                                                {{ $conversation->unread_messages_count }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <form action="{{ route('chat.destroy', $conversation) }}"
                                    method="POST"
                                    class="mt-2 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <div>
                                        <label class="text-xs text-gray-500">
                                            <input type="checkbox"
                                                name="for_both"
                                                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                            {{ __('Видалити для всіх') }}
                                        </label>
                                    </div>
                                    <button type="submit"
                                        onclick="return confirm('Are you sure?')"
                                        class="text-xs text-red-500 hover:underline">
                                        {{ __('Видалити чат') }}
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p>У вас ще немає жодного чату.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>