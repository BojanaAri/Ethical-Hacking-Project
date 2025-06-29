<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('A08: Software and Data Integrity Failures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Insecure Update Section -->
                        <div class="border border-red-500 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-red-600 mb-4">Insecure Software Update</h3>
                            <p class="mb-4 text-sm">This demonstrates downloading and executing code without verification.</p>
                            <form method="POST" action="{{ url('/software-integrity/insecure-update') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Update URL:</label>
                                    <input type="text" name="update_url" value="https://example.com/updates/latest.zip"
                                           class="w-full px-3 py-2 border rounded dark:bg-gray-700">
                                </div>
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Run Insecure Update
                                </button>
                            </form>
                        </div>

                        <!-- Secure Update Section -->
                        <div class="border border-green-500 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-600 mb-4">Secure Software Update</h3>
                            <p class="mb-4 text-sm">This demonstrates proper update verification with checksum and signature.</p>
                            <form method="POST" action="{{ url('/software-integrity/secure-update') }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Run Secure Update
                                </button>
                            </form>
                        </div>

                        <!-- Serialized Data Section -->
                        <div class="border border-red-500 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-red-600 mb-4">Insecure Serialized Data Processing</h3>
                            <p class="mb-4 text-sm">This demonstrates processing untrusted serialized data (vulnerable to object injection).</p>
                            <form method="POST" action="{{ url('/software-integrity/process-serialized') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Serialized Data:</label>
                                    <textarea name="serialized_data" class="w-full px-3 py-2 border rounded dark:bg-gray-700" rows="3">
O:8:"stdClass":1:{s:4:"test";s:12:"Hello World!";}
                                    </textarea>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Process Serialized Data
                                </button>
                            </form>
                        </div>

                        <!-- JSON Data Section -->
                        <div class="border border-green-500 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-600 mb-4">Secure JSON Data Processing</h3>
                            <p class="mb-4 text-sm">This demonstrates secure processing of JSON data instead of serialized data.</p>
                            <form method="POST" action="{{ url('/software-integrity/process-json') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">JSON Data:</label>
                                    <textarea name="json_data" class="w-full px-3 py-2 border rounded dark:bg-gray-700" rows="3">
{"test": "Hello World!"}
                                    </textarea>
                                </div>
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Process JSON Data
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">About A08: Software and Data Integrity Failures</h3>
                        <p class="mb-2">This vulnerability occurs when software and data integrity is not maintained, including:</p>
                        <ul class="list-disc pl-5 mb-4">
                            <li>Downloading and running software updates without integrity verification</li>
                            <li>Processing untrusted serialized data leading to object injection</li>
                            <li>CI/CD pipeline vulnerabilities allowing malicious code injection</li>
                        </ul>
                        <p><strong>Secure Practices:</strong></p>
                        <ul class="list-disc pl-5">
                            <li>Use digital signatures to verify software updates</li>
                            <li>Implement checksum verification for downloaded files</li>
                            <li>Avoid unserializing untrusted data - use JSON instead</li>
                            <li>Secure your CI/CD pipeline with proper access controls</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
