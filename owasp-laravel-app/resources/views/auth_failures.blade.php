<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('A07:2021 - Identification and Authentication Failures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Vulnerable Login -->
                        <div class="border p-4 rounded">
                            <h3 class="text-lg font-bold text-red-600 mb-4">Vulnerable Login (No Rate Limiting)</h3>
                            <form method="POST" action="{{ route('a07.vulnerable_login') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="email" class="block mb-2">Email</label>
                                    <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block mb-2">Password</label>
                                    <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                                </div>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Login</button>
                            </form>
                            <p class="mt-4 text-sm text-red-500">This form is vulnerable to brute force attacks as it has no rate limiting.</p>
                        </div>

                        <!-- Secure Login -->
                        <div class="border p-4 rounded">
                            <h3 class="text-lg font-bold text-green-600 mb-4">Secure Login (With Rate Limiting)</h3>
                            <form method="POST" action="{{ route('a07.secure_auth_login') }}">
                                @error('rate_limit')
                                <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                                    {{ $message }}
                                </div>
                                @enderror
                                @csrf
                                <div class="mb-4">
                                    <label for="email" class="block mb-2">Email</label>
                                    <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block mb-2">Password</label>
                                    <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                                </div>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Login</button>
                            </form>
                            <p class="mt-4 text-sm text-green-500">This form is protected with rate limiting (5 attempts per minute).</p>
                        </div>

                        <!-- Weak Password Registration -->
                        <div class="border p-4 rounded">
                            <h3 class="text-lg font-bold text-red-600 mb-4">Weak Password Policy</h3>
                            <form method="POST" action="{{ route('a07.weak_password_register') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block mb-2">Name</label>
                                    <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block mb-2">Email</label>
                                    <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block mb-2">Password (min 4 chars)</label>
                                    <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                                </div>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Register</button>
                            </form>
                            <p class="mt-4 text-sm text-red-500">This form accepts weak passwords (minimum 4 characters, no complexity requirements).</p>
                        </div>

                        <!-- Secure Password Registration -->
                        <div class="border p-4 rounded">
                            <h3 class="text-lg font-bold text-green-600 mb-4">Strong Password Policy</h3>
                            <form method="POST" action="{{ route('a07.secure_password_register') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block mb-2">Name</label>
                                    <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block mb-2">Email</label>
                                    <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block mb-2">Password</label>
                                    <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                                    <p class="text-xs mt-1">Minimum 8 characters with mixed case, numbers, and symbols</p>
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="block mb-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded" required>
                                </div>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
                            </form>
                            <p class="mt-4 text-sm text-green-500">This form enforces strong password requirements (min 8 chars, mixed case, numbers, symbols).</p>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <h3 class="text-lg font-bold mb-2">About A07:2021 - Identification and Authentication Failures</h3>
                        <p class="mb-4">This vulnerability occurs when authentication mechanisms are implemented incorrectly, allowing attackers to compromise passwords, keys, or session tokens.</p>

                        <h4 class="font-bold mt-4">Common Issues:</h4>
                        <ul class="list-disc pl-5 mb-4">
                            <li>No or weak rate limiting on authentication</li>
                            <li>Weak password policies</li>
                            <li>Plain text or weakly hashed passwords</li>
                            <li>Missing or weak multi-factor authentication</li>
                        </ul>

                        <h4 class="font-bold mt-4">Laravel Protections:</h4>
                        <ul class="list-disc pl-5">
                            <li>Built-in rate limiting (throttling)</li>
                            <li>Strong password hashing (bcrypt by default)</li>
                            <li>Password validation rules</li>
                            <li>CSRF protection</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
