<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Styled Sort Filters -->
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

            <div class="p-6 text-gray-900 dark:text-gray-100">
                <table class="border-collapse w-full border">
                    <tr class="border">
                        <th class="border p-2">id</th>
                        <th class="border p-2">name</th>
                        <th class="border p-2">surname</th>
                        <th class="border p-2">nickname</th>
                        <th class="border p-2">email</th>
                        <th class="border p-2">phone</th>
                        <th class="border p-2">Block</th>
                        <th class="border p-2">Send message</th>
                    </tr>
                    @foreach($users as $user)
                        <tr class="border">
                            <td class="border p-2">{{ $user->id }}</td>
                            <td class="border p-2">{{ $user->name }}</td>
                            <td class="border p-2">{{ $user->surname }}</td>
                            <td class="border p-2">{{ $user->nickname }}</td>
                            <td class="border p-2">{{ $user->email }}</td>
                            <td class="border p-2">{{ $user->phone }}</td>
                            <td class="border p-2">
                                <form action=" {{ route('admin.user.block', ['id' => $user->id]) }} " method="post">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button type="submit">
                                        {{ $user->deleted_at ? 'Unblock' : 'Block' }}
                                    </x-primary-button>

                                </form>
                            </td>
                            <td class="border p-2">
                                <a href="{{ route('admin.user.message', ['id' => $user->id]) }}">send message</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="mt-3.5">
                {{ $users->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-admin-layout>
