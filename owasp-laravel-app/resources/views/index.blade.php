<x-app-layout>
    {{-- Optional login/register navigation --}}
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden mx-auto">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    {{-- Authenticated users don’t need login/register links --}}
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    {{-- Main content --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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
</x-app-layout>
