<div class="space-y-6">

    @foreach($publications as $publication)
        <div class="bg-gray-800 bg-opacity-75 rounded-lg overflow-hidden border border-gray-700">
            <!-- Post header -->
            <div class="flex items-center justify-between p-3 {{ $publication->deleted_at ? 'bg-gray-300' : '' }}">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-600 mr-3 flex items-center justify-center">
                        @if($publication->user->getMedia('profile_images')->isNotEmpty())

                            <img class="w-12 h-12 rounded-full bg-cover"
                                 src="{{ $publication->user->getFirstMediaUrl('profile_images') }}"
                                 alt="Publication Image">
                        @else

                            <span
                                class="text-white font-semibold">{{ strtoupper(substr($publication->user->nickname, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm"><a
                                href="{{ route('users.profile', ['id' => $publication->user_id]) }}">{{ $publication->nickname }}</a>
                        </p>
                        <p class="text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($publication->updated_at)->diffForHumans() }}

                        </p>
                    </div>
                </div>
                @if($publication->user_id == auth()->user()->id)
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>Options</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('publication.edit', ['id' => $publication->id]) }}">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <x-dropdown-link>
                                    <form
                                        action="{{ route('publication.hide', ['publication_id' => $publication->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('patch')
                                        <button
                                            type="submit">{{ is_null($publication->deleted_at) ? 'Hide' : 'Unhide' }}</button>
                                    </form>
                                </x-dropdown-link>

                                <x-dropdown-link>
                                    <form action="{{ route('publication.destroy', $publication->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit">Delete</button>
                                    </form>
                                </x-dropdown-link>


                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif


            </div>

            <!-- Post image -->
            <div class="bg-gray-900 bg-opacity-75">
                <div class="text-center p-4">
                    <h2 class="text-xl font-bold text-white mb-2">{{ $publication->title }}</h2>
                    @if($publication->description)
                        <p class="text-gray-300">{{ $publication->description }}</p>
                    @endif
                </div>
                @if($publication->getMedia('publication_images')->isNotEmpty())
                    <div class="w-full">
                        <img src="{{ $publication->getFirstMediaUrl('publication_images') }}" alt="Publication Image"
                             class="w-full object-contain max-h-96">
                    </div>
                @endif
            </div>

            <!-- Action buttons -->
            <div class="p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex space-x-4">
                        <form class="like-form flex items-center w-8" data-publication-id="{{ $publication->id }}">
                            @csrf
                            <button type="submit"
                                    class="group flex items-center text-gray-500 transition-colors like-button">
                                @if($publication->is_liked)
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                         viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                        <path
                                            d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                         viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                        <path
                                            d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/>
                                    </svg>
                                @endif
                                <span class="likes-count text-sm ml-1">{{ $publication->likes ?? 0 }}</span>
                            </button>
                        </form>

                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </button>

                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </button>
                    </div>
                    @if($publication->user_id !== auth()->user()->id)
                        <form class="repost-form flex items-center w-8" data-publication-id="{{ $publication->id }}">
                            @csrf
                            <button type="submit"
                                    class="group flex items-center text-gray-500 transition-colors like-button">
                                @if($publication->is_reposted)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="blue"
                                         viewBox="0 0 24 24" stroke="blue">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="gray"
                                         viewBox="0 0 24 24" stroke="blue">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                    </svg>
                                @endif
                                <span class="reposts-count text-sm ml-1">{{ $publication->reposts ?? 0 }}</span>
                            </button>
                        </form>
                    @endif
                </div>


                <!-- Comments section preview -->
                <div class="mt-2">
                    <!-- Replace your existing "View all comments" with this -->
                    <p class="text-gray-400 text-xs cursor-pointer comments-trigger">{{ __('publication.viewComments') }}
                        ({{$publication->commentsCount}})</p>

                    <!-- Add this modal HTML at the end of your blade template, outside the foreach loop -->
                    <div id="comments-popup"
                         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-gray-800 rounded-lg w-full max-w-md mx-4 overflow-hidden border border-gray-700">
                            <!-- Header with tabs -->
                            <div class="flex border-b border-gray-700">
                                <button id="comments-tab"
                                        class="flex items-center justify-center gap-2 py-3 px-4 flex-1 text-white border-b-2 border-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>{{ __('publication.allComments') }}</span>
                                </button>

                                <button id="likes-tab"
                                        class="flex items-center justify-center gap-2 py-3 px-4 flex-1 text-gray-400 hover:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960"
                                         width="18px" fill="currentColor">
                                        <path
                                            d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                    </svg>
                                    <span>{{ __('publication.usersLike') }}</span>
                                </button>

                                <button id="close-popup" class="text-gray-400 hover:text-white p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Content area -->
                            <div class="max-h-96 overflow-y-auto p-4">
                                <!-- Comments content -->
                                <div id="comments-content" class="space-y-4">
                                    @if(!empty($publication->comments))
                                        @foreach($publication->comments as $comment)
                                            <p class="text-gray-300">{{ $comment->nickname }}
                                                : {{ $comment->comment }}</p>
                                            <form class="like-comment-form flex items-center w-8"
                                                  data-comment-id="{{ $comment->id }}">
                                                @csrf
                                                <button type="submit"
                                                        class="group flex items-center text-gray-500 transition-colors like-button">
                                                    @if($comment->is_liked)
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                             viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                                            <path
                                                                d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                             viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                                            <path
                                                                d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/>
                                                        </svg>
                                                    @endif
                                                    <span
                                                        class="likes-count text-sm ml-1">{{ $comment->likes ?? 0 }}</span>
                                                </button>
                                            </form>

                                        @endforeach
                                    @endif
                                </div>

                                <!-- Likes content (hidden by default) -->
                                <div id="likes-content" class="space-y-4 hidden">
                                    <p class="text-gray-300">{{ __('publication.noLikes') }}</p>
                                </div>
                            </div>

                            <!-- Add comment section (only shown in comments tab) -->
                            <div id="comment-input-section" class="border-t border-gray-700 p-3">
                                <form action="{{ route('comment.create') }}" method="post" class="relative">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="publication_id" value="{{ $publication->id }}">
                                    <input type="text" name="comment" placeholder="{{ __('publication.addComment') }}"
                                           class="w-full bg-transparent border-none text-gray-300 text-sm focus:outline-none focus:ring-0 pl-0 pr-16">
                                    <button type="submit"
                                            class="absolute right-0 top-0 text-yellow-400 text-sm font-semibold">{{ __('publication.post') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('comment.create') }}" method="post" class="mt-3 relative">
                        @csrf
                        @method('put')
                        <input type="hidden" name="publication_id" value="{{ $publication->id }}">
                        <input type="text" name="comment" placeholder="{{ __('publication.addComment') }}"
                               class="w-full bg-transparent border-none text-gray-300 text-sm focus:outline-none focus:ring-0 pl-0 pr-16">
                        <button type="submit"
                                class="absolute right-0 top-0 text-yellow-400 text-sm font-semibold">{{ __('publication.post') }}</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
