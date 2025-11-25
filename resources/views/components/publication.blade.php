        <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-200 {{ $publication->deleted_at ? 'opacity-60' : '' }}">
<div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-200 {{ $publication->deleted_at ? 'opacity-60' : '' }}">

    <!-- Post header -->
    <div class="flex items-center justify-between p-4 {{ $publication->deleted_at ? 'bg-gray-100 dark:bg-gray-700/50' : '' }}">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-white dark:ring-gray-800 overflow-hidden">
                            @if($publication->user->getProfilePicture())
                        <img class="w-full h-full object-cover"
                                    src="{{ $publication->user->getProfilePicture() }}"
                            alt="Profile Image">
                    @else
                                <span class="text-white font-bold text-lg">{{ strtoupper(substr($publication->author(), 0, 1)) }}</span>
                    @endif
                </div>
            </div>
            <div>
                <p class="text-gray-900 dark:text-white font-semibold text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        @if (!$publication->isOwn())
                        <a href="{{ route('users.profile', ['id' => $publication->user->id]) }}">
                                {{ $publication->author() }}
                        </a>
                    @else
                        Own
                    @endif
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-xs flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ \Carbon\Carbon::parse($publication->updated_at)->diffForHumans() }}
                </p>
            </div>
        </div>

                @if($publication->isOwn())
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right"
                    width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(!$publication->deleted_at)
                            <x-dropdown-link href="{{ route('publication.edit', ['id' => $publication->id]) }}">
                                {{ __('Edit') }}
                            </x-dropdown-link>
                        @endif
                        <x-dropdown-link>
                            <form action="{{ route('publication.hide', ['publication_id' => $publication->id]) }}"
                                method="post">
                                @csrf
                                @method('patch')
                                <button type="submit">{{ is_null($publication->deleted_at) ? 'Hide' : 'Unhide' }}</button>
                            </form>
                        </x-dropdown-link>

                        <x-dropdown-link>
                            <form action="{{ route('publication.destroy', $publication->id) }}"
                                method="post">
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

    <!-- Post content -->
    <div class="bg-gray-50 dark:bg-gray-900/50">
        <div class="p-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ $publication->title }}</h2>
            @if($publication->description)
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $publication->description }}</p>
            @endif
        </div>

        @if($publication->getMedia('publication_images')->isNotEmpty())
            <div class="w-full bg-gray-100 dark:bg-gray-800">
                <img src="{{ $publication->getFirstMediaUrl('publication_images') }}"
                    alt="Publication Image"
                    class="w-full object-contain max-h-96">
            </div>
        @endif
    </div>

    <!-- Action buttons -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-6">
                <!-- Like button -->
                <form class="like-form"
                    data-publication-id="{{ $publication->id }}">
                    @csrf
                    <button type="submit"
                        class="group flex items-center space-x-2 transition-all duration-200 hover:scale-105 like-button">
                                @if($publication->isLiked())
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                        viewBox="0 -960 960 960">
                                        <path fill="#EF4444" d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 -960 960 960"
                                fill="#9CA3AF">
                                <path d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/>
                            </svg>
                        @endif
                                <span class="likes-count text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $publication->countLikes() }}</span>
                    </button>
                </form>

                <!-- Comment button -->
                        <button class="comments-trigger group flex items-center space-x-2 transition-all duration-200 hover:scale-105 focus:outline-none"
                            data-publication-id="{{ $publication->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-gray-400 dark:text-gray-500 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $publication->countComments() }}</span>
                </button>
            </div>

            <!-- Repost button -->
                    @if(!$publication->isOwn())
                <form class="repost-form"
                    data-publication-id="{{ $publication->id }}">
                    @csrf
                    <button type="submit"
                        class="group flex items-center space-x-2 transition-all duration-200 hover:scale-105 like-button">
                                @if($publication->isReposted())
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-blue-500 dark:text-blue-400"
                                fill="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-gray-400 dark:text-gray-500 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        @endif
                        <span class="reposts-count text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $publication->reposts ?? 0 }}</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Comments section preview -->
        <div class="mt-2">
            <!-- Comments Modal -->
                    <div id="comments-popup-{{ $publication->id }}"
                        class="comments-popup-modal fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-700 flex flex-col">

                    <!-- Header with tabs -->
                    <div class="flex border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                <button id="comments-tab-{{ $publication->id }}"
                            class="flex items-center justify-center gap-2 py-4 px-6 flex-1 text-gray-900 dark:text-white font-semibold border-b-2 border-blue-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>{{ __('publication.allComments') }}</span>
                        </button>

                                <button id="likes-tab-{{ $publication->id }}"
                            class="flex items-center justify-center gap-2 py-4 px-6 flex-1 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                height="18px"
                                viewBox="0 -960 960 960"
                                width="18px"
                                fill="currentColor">
                                <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                            </svg>
                            <span>{{ __('publication.usersLike') }}</span>
                        </button>

                        <button id="close-popup"
                                    class="close-popup-btn text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 p-4 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Content area -->
                    <div class="flex-1 overflow-y-auto p-6 max-h-96">
                        <!-- Comments content -->
                                <div id="comments-content-{{ $publication->id }}"
                            class="space-y-4">
                            @if(!empty($publication->comments))
                                @foreach($publication->comments as $comment)
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                        @if (!$comment->isOwn())
                                                            <a href="{{ route('users.profile', ['id' => $comment->user->id]) }}"
                                                            class="font-semibold text-gray-900 dark:text-white text-sm mb-1">
                                                                {{ $comment->author() }}
                                                            </a>
                                                        @else
                                                            <p class="font-semibold italic text-gray-900 dark:text-white text-sm mb-1">Own</p>
                                                        @endif
                                                <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                                            </div>

                                            <form class="like-comment-form"
                                                data-comment-id="{{ $comment->id }}">
                                                @csrf
                                                <button type="submit"
                                                    class="group flex items-center space-x-1 transition-all duration-200 hover:scale-105 like-button">
                                                    @if($comment->is_liked)
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            height="20px"
                                                            viewBox="0 -960 960 960"
                                                            width="20px"
                                                            fill="#EF4444">
                                                            <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                                        </svg>
                                                    @else
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            height="20px"
                                                            viewBox="0 -960 960 960"
                                                            width="20px"
                                                            fill="#9CA3AF">
                                                            <path d="M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z"/>
                                                        </svg>
                                                    @endif
                                                    <span class="likes-count text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $comment->likes ?? 0 }}</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-600 mb-3"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">No comments yet</p>
                                </div>
                            @endif
                        </div>
                                <div id="likes-content-{{ $publication->id }}"
                                @if(!empty($publication->likes()))
                                    @foreach($publication->likes()->get() as $like)
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    @if (!$like->isOwn())
                                                        <a href="{{ route('users.profile', ['id' => $like->user->id]) }}"
                                                            class="font-semibold text-gray-900 dark:text-white text-sm mb-1">
                                                            {{ $like->author() }}
                                                        </a>
                                                    @else
                                                        <p class="font-semibold italic text-gray-900 dark:text-white text-sm mb-1">Own</p>
                                                    @endif
                                                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-8">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-600 mb-3"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">No comments yet</p>
                                    </div>
                                @endif
                                    <div class="space-y-4 hidden">
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-16 w-16 mx-auto text-gray-300 dark:text-gray-600 mb-3"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('publication.noLikes') }}</p>
                            </div>
                        </div>
                    </div>
                    @if(!$publication->deleted_at)
                        <!-- Add comment section -->
                                <div id="comment-input-section-{{ $publication->id }}"
                            class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-900/50">
                            <form action="{{ route('comment.create') }}"
                                method="post"
                                class="flex items-center space-x-3">
                                @csrf
                                @method('put')
                                <input type="hidden"
                                    name="publication_id"
                                    value="{{ $publication->id }}">
                                <input type="text"
                                    name="comment"
                                    placeholder="{{ __('publication.addComment') }}"
                                    class="flex-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-full px-4 py-2.5 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                <button type="submit"
                                    class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
                                    {{ __('publication.post') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @if(!$publication->deleted_at)
                <!-- Add comment form (outside modal) -->
                <form action="{{ route('comment.create') }}"
                    method="post"
                    class="mt-3 relative">
                    @csrf
                    @method('put')
                    <input type="hidden"
                        name="publication_id"
                        value="{{ $publication->id }}">
                    <div class="flex items-center space-x-3">
                        <input type="text"
                            name="comment"
                            placeholder="{{ __('publication.addComment') }}"
                            class="flex-1 bg-gray-100 dark:bg-gray-700 border-none rounded-full px-4 py-2.5 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
                            {{ __('publication.post') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
