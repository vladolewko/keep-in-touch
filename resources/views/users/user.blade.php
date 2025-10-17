<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$user->nickname}} {{ __('navigation.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.profile-info')
            @if($haveAccess)
                <div class="space-y-6">
                    @foreach($publications as $publication)
                        @include('components.publication')
                    @endforeach

                    @foreach($reposts as $repost)
                        @include('components.repost')
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
