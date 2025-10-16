<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$user->nickname}} {{ __('navigation.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @include('components.profile-info')
            <form method="POST" action="{{ route('chat.start', ['user' => $user]) }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Написати повідомлення
                </button>
            </form>
            @if($user->haveAccess === true)

                @include('components.publication')

                @include('components.repost')
            @endif
        </div>
    </div>
</x-app-layout>
