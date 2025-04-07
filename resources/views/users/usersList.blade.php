<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach($users as $user)
                        <div class="mx-auto mb-5">
                            <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 p-6">
                                <!-- Profile header -->
                                <div class="flex items-center justify-between mb-6 border-b border-gray-700 pb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gray-600 mr-4 flex items-center justify-center">
                                            <span
                                                class="text-white text-xl font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h2 class="text-white text-xl font-bold">{{ $user->nickname }}</h2>
                                            <p class="text-gray-400 text-sm">{{ $user->name }} {{ $user->surname ?? '' }}</p>
                                        </div>
                                    </div>
                                    @if($user->subscription_status === 'requested')
                                        <div>
                                            <p class="text-black dark:text-gray-200">Requested</p>
                                        </div>
                                    @elseif($user->subscription_status === true)
                                        <div>
                                            <p class="text-black dark:text-yellow-200">Subscribed</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Profile details -->
                                <div class="space-y-4">
                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">Name:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->name }}</div>
                                    </div>

                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">Surname:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->surname ?? '-' }}</div>
                                    </div>

                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">Nickname:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->nickname }}</div>
                                    </div>


                                    <div class="flex">
                                        <div class="w-28 text-gray-400 font-semibold text-sm">Bio:</div>
                                        <div class="text-white text-sm flex-1">{{ $user->bio ?? '-' }}</div>
                                    </div>

                                </div>
                                <p><a href="{{ route('users.profile', ['id' => $user->id]) }}">go to page</a></p>
                            </div>
                        </div>
                    @endforeach
                </div>

        </div>
    </div>
</x-app-layout>
