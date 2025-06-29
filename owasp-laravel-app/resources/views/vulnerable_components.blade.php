<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('A06:2021 - Vulnerable and Outdated Components') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-6">
                        <div class="p-4 border rounded-lg border-red-500">
                            <h3 class="text-lg font-bold text-red-600">Outdated Framework Version</h3>
                            <p>Current Laravel version: {{ $laravelVersion }}</p>
                            <p class="{{ $isOutdated ? 'text-red-500' : 'text-green-500' }}">
                                {{ $isOutdated ? 'VULNERABLE: Using outdated version' : 'Secure: Using current version' }}
                            </p>
                        </div>

                        <div class="p-4 border rounded-lg border-red-500">
                            <h3 class="text-lg font-bold text-red-600">Vulnerable Package</h3>
                            <pre>{{ json_encode($vulnerablePackage, JSON_PRETTY_PRINT) }}</pre>
                            <p class="text-red-500">This package contains known vulnerabilities!</p>
                        </div>

                        <div class="p-4 border rounded-lg border-yellow-500">
                            <h3 class="text-lg font-bold">Test XML External Entity (XXE) Vulnerability</h3>
                            <form id="xmlForm" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="xml" class="block mb-2">XML Input:</label>
                                    <textarea id="xml" name="xml" rows="5" class="w-full p-2 border rounded dark:bg-gray-700">
                                        <!DOCTYPE test [ <!ENTITY xxe SYSTEM "file:///etc/passwd"> ]>
                                        <test>&xxe;</test>
                                    </textarea>
                                </div>
                                <button type="button" onclick="submitXml()"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Test Vulnerable Parser
                                </button>
                            </form>
                            <div id="xmlResult" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded hidden"></div>
                        </div>

                        <div class="p-4 border rounded-lg border-yellow-500">
                            <h3 class="text-lg font-bold">Insecure Update Check</h3>
                            <button onclick="checkUpdates()"
                                    class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                Check for Updates (Insecure)
                            </button>
                            <div id="updateResult" class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded hidden"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitXml() {
            const form = document.getElementById('xmlForm');
            const resultDiv = document.getElementById('xmlResult');

            fetch('/vulnerable-components/parse-xml', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: `xml=${encodeURIComponent(form.xml.value)}`
            })
                .then(response => response.json())
                .then(data => {
                    resultDiv.classList.remove('hidden');
                    resultDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    resultDiv.classList.remove('hidden');
                    resultDiv.innerHTML = `Error: ${error}`;
                });
        }

        function checkUpdates() {
            const resultDiv = document.getElementById('updateResult');

            fetch('/vulnerable-components/check-updates')
                .then(response => response.json())
                .then(data => {
                    resultDiv.classList.remove('hidden');
                    resultDiv.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    resultDiv.classList.remove('hidden');
                    resultDiv.innerHTML = `Error: ${error}`;
                });
        }
    </script>
</x-app-layout>
