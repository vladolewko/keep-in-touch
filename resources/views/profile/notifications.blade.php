<x-app-layout>

@foreach ($notifications as $notification)
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $notification->topic }}</h3>
        <p class="text-gray-600 dark:text-gray-400">{{ $notification->message }}</p>
        <span class="text-sm text-gray-500 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
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
</x-app-layout>
