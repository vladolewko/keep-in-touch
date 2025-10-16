<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-4">
                        <div class="flex">
                            <div class="w-28 text-gray-400 font-semibold text-sm">Edit Profile data:</div>
                            <div class="text-white text-sm flex-1"><a href="{{ route('profile.edit') }}">Edit</a></div>
                        </div>

                        <div class="flex">
                            <div class="w-28 text-gray-400 font-semibold text-sm">2:</div>
                            <div class="text-white text-sm flex-1"></div>
                        </div>

                        <div class="flex">
                            <div class="w-28 text-gray-400 font-semibold text-sm">3:</div>
                            <div class="text-white text-sm flex-1"></div>
                        </div>

                        <div class="flex">
                            <div class="w-28 text-gray-400 font-semibold text-sm">4:</div>
                            <div class="text-white text-sm flex-1"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
