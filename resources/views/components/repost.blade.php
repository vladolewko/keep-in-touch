<div class="space-y-6">
    @foreach($reposts as $repost)
        <div class="bg-gray-800 rounded-lg overflow-hidden border border-gray-700">
            <!-- Post header -->
            <div class="flex items-center justify-between p-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-600 mr-3 flex items-center justify-center">
                        <span class="text-white font-semibold">{{ strtoupper(substr($repost->id, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">{{ $repost->id }}</p>
                        <p class="text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($repost->updated_at)->diffForHumans() }}

                        </p>
                    </div>
                </div>

              <p class="text-black dark:text-gray-200">Reposted</p>
            </div>

            <!-- Post image -->
            <div class="aspect-w-4 aspect-h-3 bg-gray-900 flex items-center justify-center">
                <div class="text-center p-4">
                    <h2 class="text-xl font-bold text-white mb-2">{{ $repost->title }}</h2>
                    @if($repost->description)
                        <p class="text-gray-300">{{ $repost->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Action buttons -->
            <div class="p-3">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex space-x-4">
                        <form class="like-form flex items-center w-8" data-publication-id="{{ $repost->id }}">
                            @csrf
                            <button type="submit" class="group flex items-center text-gray-500 transition-colors like-button">
                                @if($repost->is_liked)
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
                                <span class="likes-count text-sm ml-1">{{ $repost->likes ?? 0 }}</span>
                            </button>
                        </form>


                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </button>

                        <button class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </button>
                    </div>

                    <form class="repost-form flex items-center w-8" data-publication-id="{{ $repost->id }}">
                        @csrf
                        <button type="submit" class="group flex items-center text-gray-500 transition-colors like-button">
                            @if($repost->is_reposted)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="blue" viewBox="0 0 24 24" stroke="blue">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 hover:text-white transition-colors" fill="gray" viewBox="0 0 24 24" stroke="blue">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                            @endif
                            <span class="reposts-count text-sm ml-1">{{ $repost->reposts ?? 0 }}</span>
                        </button>
                    </form>
                </div>


                <!-- Comments section preview -->
                <div class="mt-2">
                    <p class="text-gray-400 text-xs">View all comments</p>
                    <div class="mt-3 relative">
                        <input type="text" placeholder="Add a comment..." class="w-full bg-transparent border-none text-gray-300 text-sm focus:outline-none focus:ring-0 pl-0 pr-16"><button class="absolute right-0 top-0 text-yellow-400 text-sm font-semibold">Post</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
