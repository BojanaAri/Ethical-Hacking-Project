<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('A10:2021 - Server-Side Request Forgery (SSRF)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-2">Vulnerable SSRF Implementation</h3>
                        <p class="mb-4 text-red-500">Warning: This is intentionally vulnerable - do not expose in production!</p>

                        <form id="ssrfForm" class="mb-4">
                            @csrf
                            <div class="mb-4">
                                <label for="url" class="block mb-2">URL to fetch:</label>
                                <input type="text" name="url" id="url"
                                       class="w-full px-3 py-2 border rounded dark:bg-gray-700"
                                       value="https://example.com" required>
                            </div>
                            <button type="button" onclick="fetchUrl()"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Fetch URL (Vulnerable)
                            </button>
                        </form>

                        <div class="border p-4 rounded bg-gray-100 dark:bg-gray-700">
                            <h4 class="font-semibold mb-2">Response:</h4>
                            <pre id="ssrfResult" class="text-sm overflow-auto max-h-60"></pre>
                        </div>
                    </div>

                    <hr class="my-8 border-gray-300 dark:border-gray-600">

                    <div>
                        <h3 class="text-lg font-semibold mb-2">Secure SSRF Implementation</h3>
                        <p class="mb-4 text-green-500">This implementation includes proper validation and allowlisting.</p>

                        <form id="secureSsrfForm" class="mb-4">
                            @csrf
                            <div class="mb-4">
                                <label for="secureUrl" class="block mb-2">URL to fetch (only allowed domains):</label>
                                <input type="text" name="url" id="secureUrl"
                                       class="w-full px-3 py-2 border rounded dark:bg-gray-700"
                                       value="https://api.example.com" required>
                                <p class="text-sm text-gray-500 mt-1">Allowed domains: api.example.com, trusted-service.com</p>
                            </div>
                            <button type="button" onclick="fetchUrlSecure()"
                                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Fetch URL (Secure)
                            </button>
                        </form>

                        <div class="border p-4 rounded bg-gray-100 dark:bg-gray-700">
                            <h4 class="font-semibold mb-2">Response:</h4>
                            <pre id="secureSsrfResult" class="text-sm overflow-auto max-h-60"></pre>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchUrl() {
            const form = document.getElementById('ssrfForm');
            const result = document.getElementById('ssrfResult');
            result.textContent = 'Loading...';

            fetch('/ssrf/fetch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    url: form.url.value
                })
            })
                .then(response => response.json())
                .then(data => {
                    result.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    result.textContent = 'Error: ' + error.message;
                });
        }

        function fetchUrlSecure() {
            const form = document.getElementById('secureSsrfForm');
            const result = document.getElementById('secureSsrfResult');
            result.textContent = 'Loading...';

            fetch('/ssrf/fetch-secure', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    url: form.url.value
                })
            })
                .then(response => response.json())
                .then(data => {
                    result.textContent = JSON.stringify(data, null, 2);
                })
                .catch(error => {
                    result.textContent = 'Error: ' + error.message;
                });
        }
    </script>
</x-app-layout>
