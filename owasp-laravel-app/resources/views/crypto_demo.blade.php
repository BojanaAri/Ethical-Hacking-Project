<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('A02 - Cryptographic Failures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email"
                                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring focus:ring-indigo-200"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password</label>
                            <input type="text" name="password" id="password"
                                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring focus:ring-indigo-200"
                                   required>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" formaction="{{ url('/store-passwords') }}"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Store Password
                            </button>
                        </div>
                    </form>

                    <hr class="my-8 border-gray-400 dark:border-gray-600" />

                    <h3 class="text-xl font-semibold text-center mt-4 mb-4">Stored Passwords Comparison</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2">Insecure (Plaintext)</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 dark:border-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Email</th>
                                        <th class="px-4 py-2 border-b">Password</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($insecurePasswords ?? [] as $record)
                                        <tr class="border-t border-gray-300 dark:border-gray-600">
                                            <td class="px-4 py-2">{{ $record->email }}</td>
                                            <td class="px-4 py-2">{{ $record->password }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center">No records found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2">Secure (Hashed)</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 dark:border-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Email</th>
                                        <th class="px-4 py-2 border-b">Password (Hashed)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($securePasswords ?? [] as $record)
                                        <tr class="border-t border-gray-300 dark:border-gray-600">
                                            <td class="px-4 py-2">{{ $record->email }}</td>
                                            <td class="px-4 py-2">{{ $record->password }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center">No records found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
