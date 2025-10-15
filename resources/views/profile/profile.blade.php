<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('navigation.profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Profile Info --}}
            @include('components.profile-info')


            {{-- New Publication Form Card --}}
            <div class="bg-white dark:bg-gray-800/50 dark:border dark:border-gray-700/50 backdrop-blur-sm overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                        Create a New Post
                    </h3>

                    {{-- Display a more prominent session error message --}}
                    @if(session('error'))
                        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-900 dark:text-red-400" role="alert">
                            <span class="font-medium">Error!</span> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('publications.create') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                        @method('put')
                        @csrf

                        {{-- Title Field --}}
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Title
                            </label>
                            <x-text-input type="text"
                                          name="title"
                                          id="title"
                                          class="w-full"
                                          placeholder="What's on your mind?"
                                          required />
                            @error('title')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description Field --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                placeholder="Add more details..."
                            ></textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Custom File Upload Field --}}
                        <div>
                           <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Attach an Image
                            </label>
                            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 dark:border-gray-100/25 px-6 py-10">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div id="image-upload-text" class="mt-4 flex text-sm leading-6 text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-indigo-600 dark:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 dark:focus-within:ring-offset-gray-900 hover:text-indigo-500 dark:hover:text-indigo-300">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p id="image-upload-hint" class="text-xs leading-5 text-gray-600 dark:text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    {{-- This paragraph will display the selected file name --}}
                                    <p id="file-name-display" class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-300"></p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-end pt-4">
                            <x-primary-button>
                                <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Publish
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            @include('components.publication')
            @include('components.repost')

        </div>
    </div>
    <script>
        const fileInput = document.getElementById('image');
        const fileNameDisplay = document.getElementById('file-name-display');
        const uploadText = document.getElementById('image-upload-text');
        const uploadHint = document.getElementById('image-upload-hint');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = `Selected: ${this.files[0].name}`;
                // Optionally hide the original upload text
                uploadText.style.display = 'none';
                uploadHint.style.display = 'none';
            } else {
                fileNameDisplay.textContent = '';
                // Restore the original text if the selection is cancelled
                uploadText.style.display = 'flex';
                uploadHint.style.display = 'block';
            }
        });
    </script>
</x-app-layout>