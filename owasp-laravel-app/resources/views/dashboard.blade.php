<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{-- Show search results if any --}}
                        @isset($users)
                            @if($users->count())
                                <h2 class="text-lg font-semibold mb-4">Search Results:</h2>
                                <ul class="list-disc list-inside">
                                    @foreach($users as $user)
                                        <li>{{ $user->name }} ({{ $user->email }})</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No users found.</p>
                            @endif
                        @endisset
                    </div>

                    {{-- Search form for authenticated users --}}
                    @auth
                        <div style="margin: 20px">
                            <p class="text-white">A03 SQL Injection</p>
                            <form method="GET" action="/search" class="flex gap-2">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search users..."
                                    class="px-3 py-1 border rounded-sm dark:bg-gray-700 dark:border-gray-600 text-black dark:text-white"
                                    required>
                                <button type="submit"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-sm hover:bg-blue-600">
                                    Search
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
