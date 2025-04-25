<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Sort by:</h3>
                <div class="flex flex-wrap gap-2">

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'id ASC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') == 'id ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Id ASC
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'id DESC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'id DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Id DESC
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'name ASC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') == 'name ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Name A-Z
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'name DESC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'name DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Name Z-A
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'nickname ASC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') == 'nickname ASC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Nickname A-Z
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'nickname DESC', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'nickname DESC' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Nickname Z-A
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'newest', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ !request()->get('parameter') || request()->get('parameter') == 'newest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Newest First
                    </a>

                    <a href="{{ route('admin.users.sort', ['filter' => request()->get('filter'), 'parameter' => 'oldest', 'search' => request()->get('search')]) }}"
                       class="px-4 py-2 {{ request()->get('parameter') === 'oldest' ? 'bg-blue-500 text-white' : 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' }} rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Oldest First
                    </a>

                </div>
            </div>


            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-3">Search:</h3>
                <form action="{{ route('admin.users.sort') }}"
                      method="get"
                      class="flex items-center">
                    @csrf
                    @method('get')
                    <input type="hidden" name="parameter" value="{{ request()->get('parameter') ?? ''}}">
                    <input type="hidden" name="filter" value="{{ request()->get('filter') ?? ''}}">
                    <input type="text"
                           name="search"
                           value="{{ request()->get('search') ?? ''}}"
                           placeholder="Search publications..."
                           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 w-64">
                    <button type="submit"
                            class="px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-r-md border border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="mb-6">
                <a href="{{ route('admin.users.sort', ['parameter' => request()->get('parameter'), 'search' => request()->get('search'), 'filter' => 'blocked']) }}"
                   class="mb-3 max-w-32 px-4 py-2 'dark: {{request()->get('filter') == 'blocked' ? 'bg-blue-500 text-white' : 'bg-gray-700'}} hover:bg-gray-200  dark:hover:bg-gray-600' rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                    Deleted Only
                </a>

                <a href="{{ route('admin.users.sort', ['parameter' => request()->get('parameter'), 'search' => request()->get('search'), 'filter' => 'unblocked']) }}"
                   class="mb-3 max-w-32 px-4 py-2 'dark: {{request()->get('filter') == 'unblocked' ? 'bg-blue-500 text-white' : 'bg-gray-700'}}  hover:bg-gray-200  dark:hover:bg-gray-600' rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                    Not Deleted Only
                </a>

                <a href="{{ route('admin.users.sort', ['parameter' => null, 'search' => null]) }}"
                   class="max-w-32 px-4 py-2 'bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600' rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                    Reset All
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Surname</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nickname</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->surname }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->nickname }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="w-20 px-2 flex justify-center text-xs leading-5 font-semibold rounded-full {{ $user->deleted_at ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                {{ $user->deleted_at ? 'Blocked' : 'Active' }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-1">
                                    <form action="{{ route('admin.user.block', ['id' => $user->id]) }}" method="post" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="w-24 {{ $user->deleted_at ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }} text-white py-1 px-3 rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $user->deleted_at ? 'M13 10V3L4 14h7v7l9-11h-7z' : 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' }}" />
                                            </svg>
                                            {{ $user->deleted_at ? 'Restore' : 'Block' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.user.message', ['id' => $user->id, 'comment' => null]) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-sm font-medium transition-colors duration-150 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
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
                {{ $users->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-admin-layout>
