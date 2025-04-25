<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.subscriptions') }}
        </h2>
    </x-slot>

    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @foreach($subscriptions as $user)
                        <div class="mx-auto py-12">
                            <div class="bg-gray-800 bg-opacity-75 rounded-lg overflow-hidden border border-gray-700 p-6">
                                <!-- Profile header -->
                                <div class="flex items-center justify-between mb-6 border-b border-gray-700 pb-4">
                                    <a href="{{ route('users.profile', ['id' => $user->id]) }}">
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
                                    </a>
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
                                <form class="space-y-4" action="{{ route('user.changeSubscription', ['user_id' => $user->id]) }}" method="post">
                                    @csrf
                                    @if($user->subscription_status === 'requested')

                                        <x-secondary-button type="submit">
                                            Requested
                                        </x-secondary-button>
                                    @elseif($user->subscription_status === true)
                                        <x-primary-button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Unsubscribe
                                        </x-primary-button>
                                    @elseif($user->subscription_status === false)
                                        <x-primary-button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Subscribe
                                        </x-primary-button>
                                    @endif

                                </form>
                            </div>
                        </div>
                    @endforeach
        </div>
    </div>
</x-app-layout>
