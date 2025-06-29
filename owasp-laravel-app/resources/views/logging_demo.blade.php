<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('A09: Security Logging and Monitoring Failures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-8">
                        <!-- Section 1: Sensitive Data Logging -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <h3 class="text-lg font-medium mb-2">1. Sensitive Data in Logs</h3>
                            <p class="mb-4">Demonstration of logging sensitive information vs secure logging practices.</p>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Insecure Login Form -->
                                <div class="p-4 border border-red-500 rounded-lg">
                                    <h4 class="font-semibold text-red-600 dark:text-red-400 mb-2">Insecure Login (logs credentials)</h4>
                                    <form method="POST" action="/insecure-login">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">Email</label>
                                            <input type="email" name="email" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">Password</label>
                                            <input type="password" name="password" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            Test Insecure Login
                                        </button>
                                    </form>
                                </div>

                                <!-- Secure Login Form -->
                                <div class="p-4 border border-green-500 rounded-lg">
                                    <h4 class="font-semibold text-green-600 dark:text-green-400 mb-2">Secure Login</h4>
                                    <form method="POST" action="/secure-login">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">Email</label>
                                            <input type="email" name="email" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">Password</label>
                                            <input type="password" name="password" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Test Secure Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Critical Event Logging -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <h3 class="text-lg font-medium mb-2">2. Critical Event Logging</h3>
                            <p class="mb-4">Demonstration of missing vs proper logging of critical security events.</p>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Insecure Admin Action -->
                                <div class="p-4 border border-red-500 rounded-lg">
                                    <h4 class="font-semibold text-red-600 dark:text-red-400 mb-2">Insecure Admin Action (no logging)</h4>
                                    <form method="POST" action="/insecure-admin-action">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">User ID to modify</label>
                                            <input type="text" name="user_id" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">New Role</label>
                                            <select name="role" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                                <option value="user">User</option>
                                                <option value="editor">Editor</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            Perform Action (No Logs)
                                        </button>
                                    </form>
                                </div>

                                <!-- Secure Admin Action -->
                                <div class="p-4 border border-green-500 rounded-lg">
                                    <h4 class="font-semibold text-green-600 dark:text-green-400 mb-2">Secure Admin Action (with logging)</h4>
                                    <form method="POST" action="/secure-admin-action">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">User ID to modify</label>
                                            <input type="text" name="user_id" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">New Role</label>
                                            <select name="role" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                                <option value="user">User</option>
                                                <option value="editor">Editor</option>
                                                <option value="admin">Admin</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Perform Action (With Logs)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Log Injection -->
                        <div>
                            <h3 class="text-lg font-medium mb-2">3. Log Injection</h3>
                            <p class="mb-4">Demonstration of log injection vulnerability and proper sanitization.</p>

                            <div class="grid md:grid-cols-2 gap-4">
                                <!-- Vulnerable to Log Injection -->
                                <div class="p-4 border border-red-500 rounded-lg">
                                    <h4 class="font-semibold text-red-600 dark:text-red-400 mb-2">Vulnerable to Log Injection</h4>
                                    <form method="POST" action="/log-injection">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">Search Term</label>
                                            <input type="text" name="search" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                            <p class="text-xs text-gray-500 mt-1">Try: <code>test\n[INFO] User admin logged in</code></p>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                            Search (Unsanitized)
                                        </button>
                                    </form>
                                </div>

                                <!-- Sanitized Logging -->
                                <div class="p-4 border border-green-500 rounded-lg">
                                    <h4 class="font-semibold text-green-600 dark:text-green-400 mb-2">Sanitized Logging</h4>
                                    <form method="POST" action="/safe-logging">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium mb-1">Search Term</label>
                                            <input type="text" name="search" class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                            <p class="text-xs text-gray-500 mt-1">Try: <code>test\n[INFO] User admin logged in</code></p>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Search (Sanitized)
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
