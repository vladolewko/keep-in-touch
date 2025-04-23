
    <div class="mx-auto py-12">
        <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700 p-6">
            <!-- Profile header -->
            <div class="flex items-center mb-6 border-b border-gray-700 pb-4">
                <div class="w-16 h-16 rounded-full bg-gray-600 mr-4 flex items-center justify-center">

                    @if($user->getMedia('profile_images')->isNotEmpty())

                    <img class="w-16 h-16 rounded-full bg-cover" src="{{ $user->getFirstMediaUrl('profile_images') }}" alt="Publication Image" class="object-cover w-full h-full">
                    @else

                    <span class="text-white text-xl font-semibold">{{ strtoupper(substr($user->nickname, 0, 1)) }}</span>
                    @endif

                </div>
                <div>
                    <h2 class="text-white text-xl font-bold">{{ $user->name }} {{ $user->surname ?? '' }}</h2>
                    <p class="text-gray-400 text-sm">{{ $user->nickname }}</p>
                </div>
            </div>

            <!-- Profile details -->
            <div class="space-y-4">
                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.name') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->name }}</div>
                </div>

                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.surname') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->surname ?? '-' }}</div>
                </div>

                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.nickname') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->nickname }}</div>
                </div>

                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.email') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->email }}</div>
                </div>

                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.phone') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->phone }}</div>
                </div>

                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.bio') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->bio ?? '-' }}</div>
                </div>

                <div class="flex">
                    <div class="w-28 text-gray-400 font-semibold text-sm">{{ __('profile-info.address') }}:</div>
                    <div class="text-white text-sm flex-1">{{ $user->address ?? '-' }}</div>
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
