<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($notifications as $notification)
                <div class="bg-gray-800 rounded-lg p-4 mb-4 bg-opacity-75">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $notification->topic }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $notification->message }}</p>
                    <span
                        class="text-sm text-gray-500 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                    <div class="mt-2">
                        @if ($notification->is_read)
                            <span class="text-green-500">Readed</span>
                        @else
                            <form action="{{ route('profile.notification.read', $notification->id) }}" method="POST">
                                @csrf
                                @method('patch')
                                <button type="submit" class="text-yellow-500 hover:text-yellow-700">Read</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
