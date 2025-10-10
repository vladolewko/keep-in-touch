<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('navigation.publications') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-gray-800/50 backdrop-blur-sm overflow-hidden shadow-xl dark:shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                
                <div class="p-8">
                    <!-- Header Section -->
                    <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg shadow-blue-500/30 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    Edit Publication
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Update your publication details below
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('publication.update', ['publication_id' => $publication->id]) }}" method="post" enctype="multipart/form-data" class="space-y-6">
                        @method('patch')
                        @csrf

                        <!-- Title Field -->
                        <div class="group">
                            <label for="title" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Title
                            </label>
                            <x-text-input type="text"
                                          name="title"
                                          value="{{ $publication->title }}"
                                          id="title"
                                          class="w-full px-4 py-3 rounded-xl shadow-sm border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/70 text-gray-800 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200"
                                          placeholder="Enter publication title"/>
                        </div>

                        <!-- Image Field -->
                        <div class="group">
                            <label for="image" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Image
                            </label>
                            
                            @if($publication->getMedia('publication_images')->isNotEmpty())
                                <div class="mb-4 relative group/image">
                                    <div class="overflow-hidden rounded-xl border-2 border-gray-200 dark:border-gray-700 shadow-lg">
                                        <img src="{{ $publication->getFirstMediaUrl('publication_images') }}" 
                                             alt="Publication Image" 
                                             class="object-cover w-full h-64 group-hover/image:scale-105 transition-transform duration-300">
                                    </div>
                                    <button type="submit" 
                                            name="remove_image" 
                                            value="1" 
                                            class="mt-3 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Remove Image
                                    </button>
                                </div>
                            @endif
                            
                            <div class="relative">
                                <input type="file" 
                                       name="image" 
                                       id="image"
                                       class="block w-full text-sm text-gray-600 dark:text-gray-400
                                              file:mr-4 file:py-3 file:px-6
                                              file:rounded-xl file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              dark:file:bg-blue-900/30 dark:file:text-blue-400
                                              hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50
                                              file:transition-all file:duration-200
                                              file:cursor-pointer
                                              cursor-pointer
                                              bg-gray-50 dark:bg-gray-700/70
                                              border border-gray-300 dark:border-gray-600
                                              rounded-xl
                                              focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20">
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="group">
                            <label for="description" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                Description
                            </label>
                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                class="w-full px-4 py-3 rounded-xl shadow-sm border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/70 text-gray-800 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 transition-all duration-200 resize-none"
                                placeholder="Enter publication description">{{ $publication->description }}</textarea>
                        </div>

                        <!-- Error Message -->
                        @if(session('error'))
                            <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-500 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-medium text-red-800 dark:text-red-300">{{ session('error') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                            <x-primary-button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 flex items-center hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Publication
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>