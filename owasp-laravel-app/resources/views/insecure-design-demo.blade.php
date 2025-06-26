<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">A04: Insecure Design Demo (Using Breeze)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="py-12 max-w-3xl mx-auto text-white">
                        @if (session('status'))
                            <div class="mb-4 text-green-500 font-semibold">{{ session('status') }}</div>
                        @endif

                        <h3 class="mb-2 font-bold">Secure Profile Update (Breeze default)</h3>
                        <form method="POST" action="{{ route('profile.update') }}" class="mb-8">
                            @csrf
                            @method('patch')
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="border rounded px-2 py-1 dark:bg-gray-800 text-white mb-2">
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="border rounded px-2 py-1 dark:bg-gray-800 text-white mb-2">
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Update My Profile</button>
                        </form>

                        <hr class="my-6">

                        <h3 class="mb-2 font-bold text-red-600">Insecure Update by ID (Broken Design)</h3>
                        <form method="POST" action="{{ url('/update-any-profile/1') }}">
                            @csrf
                            <input type="text" name="name" placeholder="Name for User #1" class="border rounded px-2 py-1 dark:bg-gray-800 text-white mb-2">
                            <input type="email" name="email" placeholder="Email for User #1" class="border rounded px-2 py-1 dark:bg-gray-800 text-white mb-2">
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">
                                Update User #1 (No Check)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
