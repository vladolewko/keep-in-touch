<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.publications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Edit Publication
                    </h3>

                    <form action="{{ route('publication.update', ['publication_id' => $publication->id]) }}" method="post">
                        @method('patch')
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Title
                            </label>
                            <x-text-input type="text"
                                          name="title"
                                            value="{{ $publication->title }}"
                                          id="title"
                                          class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                          placeholder="Enter publication title"/>

                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Image
                            </label>
                            @if($publication->getMedia('publication_images')->isNotEmpty())
                                <img src="{{ $publication->getFirstMediaUrl('publication_images') }}" alt="Publication Image" class="object-cover w-full h-full">
                            @endif

                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Description
                            </label>


                            <textarea
                                name="description"

                                id="description"
                                class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                placeholder="Enter publication description"
                            >{{ $publication->description }}</textarea>
                        </div>

                        <div class="flex items-center justify-end">

                            <x-primary-button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Update!
                            </x-primary-button>

                        </div>
                        <p class="text-red-600">{{session('error') ?? ''}}</p>
                    </form>
                </div>

            </div>
        </div>
</x-app-layout>

