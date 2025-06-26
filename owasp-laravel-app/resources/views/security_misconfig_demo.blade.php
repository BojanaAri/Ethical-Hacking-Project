<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">A05: Security Misconfiguration</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="py-8 max-w-3xl mx-auto">
                        <p class="mb-4">This page demonstrates common Laravel security misconfigurations.</p>

                        <div class="mb-6">
                            <h3 class="font-bold">APP_DEBUG is enabled</h3>
                            <a href="/trigger-error" class="text-red-500 underline">Trigger error and view stack trace</a>
                        </div>

                        <div class="mb-6">
                            <h3 class="font-bold">Sensitive config leak</h3>
                            <a href="/leak-env" class="text-red-500 underline">See exposed environment values</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
