<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Publications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-5">

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Sort by:</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.comments.sort', ['parameter' => 'likes ASC', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') === 'likes ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 15l7-7 7 7"/>
                            </svg>
                            Likes (Low to High)
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'likes DESC', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') === 'likes DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                            Likes (High to Low)
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'newest', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Newest First
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'oldest', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') === 'oldest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Oldest First
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'id ASC', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') == 'id ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Id ASC
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'id DESC', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') === 'id DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Id DESC
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'nickname ASC', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') == 'nickname ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Nickname ASC
                        </a>

                        <a href="{{ route('admin.comments.sort', ['parameter' => 'nickname DESC', 'search' => request()->get('search')]) }}"
                            class="px-4 py-2 {{ request()->get('parameter') === 'nickname DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 mr-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Nickname DESC
                        </a>

                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Search:</h3>
                    <form action="{{ route('admin.comments.sort') }}"
                        method="get"
                        class="flex items-center">
                        @csrf
                        @method('get')
                        <input type="hidden"
                            name="filter"
                            value="{{ request()->get('filter') ?? ''}}">
                        <input type="hidden"
                            name="parameter"
                            value="{{ request()->get('parameter') ?? ''}}">
                        <input type="text"
                            name="search"
                            value="{{ request()->get('search') ?? ''}}"
                            placeholder="Search comment..."
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 w-64">
                        <button type="submit"
                            class="px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-r-md border border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Comment
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Likes
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($comments as $comment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $comment->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $comment->nickname }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white line-clamp-2">
                                        {{ $comment->comment }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $comment->likes }}
                                    </div>
                                </td>
                                <td class="px-1 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-1">
                                        <form action="{{ route('admin.comment.destroy', ['id' => $comment->id]) }}"
                                            method="post"
                                            class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="w-24 bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4 mr-1"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="{{ $comment->deleted_at ? 'M13 10V3L4 14h7v7l9-11h-7z' : 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' }}"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.user.message', ['userId' => $comment->user_id]) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 mr-1"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3.5">
                    {{ $comments->withQueryString()->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
