<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$user->nickname}} {{ __('navigation.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @include('components.profile-info')

            @if($user->haveAccess === true)

                @include('components.publication')

                @include('components.repost')
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.dataLayer.push(@json($profileGTM));
            console.log(dataLayer);
        });
    </script>
</x-app-layout>
