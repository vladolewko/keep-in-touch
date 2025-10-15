<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Send Message {{ $user->nickname }}
        </h2>
    </x-slot>
    @if (session('message'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.send', ['sent_to_id' => $user->id]) }}" method="post">
                        @csrf
                        @method ('put')
                        <div class="mb-4">
                            <select class="text-gray-800" name="topic" id="">
                                <option value="warning">Warning</option>
                                <option value="block">Block</option>
                                <option value="notification">Notification</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="message" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Message:</label>
                            <textarea id="message" name="message" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-800  leading-tight focus:outline-none focus:shadow-outline">{{ $comment ?? ""}}</textarea>
                            <button type="submit">send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
