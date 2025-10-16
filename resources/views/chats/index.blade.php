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

                    <div class="space-y-4">
                        @forelse ($conversations as $conversation)
                            <a href="{{ route('chat.show', $conversation) }}" class="block p-4 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name={{ optional($conversation->participants->first())->nickname }}&background=random" alt="Avatar">
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-lg font-semibold truncate">
                                            {{ optional($conversation->participants->first())->nickname }}
                                        </p>

                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            @if ($conversation->lastMessage)
                                                {{ $conversation->lastMessage->body }}
                                            @else
                                                <span class="italic">Повідомлень ще немає</span>
                                            @endif
                                        </p>
                                    </div>

                                    @if ($conversation->lastMessage)
                                        <div class="text-xs text-gray-400 self-start">
                                            {{ $conversation->lastMessage->created_at->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p>У вас ще немає жодного чату.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>