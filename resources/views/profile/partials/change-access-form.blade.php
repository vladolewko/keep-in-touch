<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Change access') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('bla bla bla') }}
        </p>
    </header>

    @if(auth()->user()->is_private == true)
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-make-public')"
        >{{ __('Make Public') }}</x-primary-button>

        <x-modal name="confirm-make-public" :show="$errors->makePublic->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.changeAccess', ['access' => '0']) }}" class="p-6">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to make your account public?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('When your account is public, all users will be able to view your profile and content without needing approval. Please enter your password to confirm this change.') }}
                </p>


                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ __('Make Public') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @else
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-make-private')"
        >{{ __('Make Private') }}</x-primary-button>

        <x-modal name="confirm-make-private" :show="$errors->makePrivate->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.changeAccess', ['access' => '1']) }}" class="p-6">
                @csrf
                @method('patch')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Are you sure you want to make your account private?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('When your account is private, only approved followers will be able to view your profile and content. Please enter your password to confirm this change.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        {{ __('Make Private') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @endif

</section>
