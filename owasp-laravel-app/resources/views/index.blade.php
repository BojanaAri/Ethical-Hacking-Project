<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OWASP Demo Portal – Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind (if not using Laravel Mix or Vite for now) -->
    @vite('resources/css/app.css') {{-- Only if you're using Vite --}}
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] p-6 lg:p-8 flex flex-col items-center justify-center min-h-screen">

<!-- Header -->
<header class="w-full max-w-4xl text-sm mb-6">
    @if (Route::has('login'))
        <nav class="flex justify-end gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm px-4 py-2 border rounded hover:underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm px-4 py-2 border rounded hover:underline">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-sm px-4 py-2 border rounded hover:underline">Register</a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<!-- Hero Section -->
<div class="text-center max-w-2xl">
    <h1 class="text-3xl sm:text-5xl font-bold mb-4">
        🔐 Laravel OWASP Top 10 Demo
    </h1>
    <p class="text-lg mb-8 text-gray-600 dark:text-gray-400">
        Explore live examples of the OWASP Top 5 vulnerabilities and learn how Laravel protects against them.
    </p>

    <!-- Links to OWASP Demos -->
    <div class="grid gap-4 md:grid-cols-2">
        @auth
        <a href="/admin" class="bg-red-100 dark:bg-red-900 p-4 rounded shadow hover:bg-red-200 transition">
            A01 – Broken Access Control
        </a>
        <a href="/crypto-demo" class="bg-orange-100 dark:bg-orange-900 p-4 rounded shadow hover:bg-orange-200 transition">
            A02 – Cryptographic Failures
        </a>
        <a href="/dashboard" class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded shadow hover:bg-yellow-200 transition">
            A03 – Injection
        </a>
        <a href="/insecure-design" class="bg-green-100 dark:bg-green-900 p-4 rounded shadow hover:bg-green-200 transition">
            A04 – Insecure Design
        </a>
        <a href="/security-misconfig" class="bg-blue-100 dark:bg-blue-900 p-4 rounded shadow hover:bg-blue-200 transition">
            A05 – Security Misconfiguration
        </a>
            <a href="/vulnerable-components" class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded shadow hover:bg-indigo-200 transition">
                A06 – Vulnerable Components
            </a>
            <a href="/a07-auth-failures" class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded shadow hover:bg-indigo-200 transition">
                A07 – Identification and Authentication Failures
            </a>
            <a href="/software-integrity" class="bg-purple-100 dark:bg-purple-900 p-4 rounded shadow hover:bg-purple-200 transition">
                A08 – Software Integrity Failures
            </a>
            <a href="/logging-demo" class="bg-indigo-100 dark:bg-indigo-900 p-4 rounded shadow hover:bg-indigo-200 transition">
                A09 – Security Logging & Monitoring Failures
            </a>
            <a href="/ssrf-demo" class="bg-purple-100 dark:bg-purple-900 p-4 rounded shadow hover:bg-purple-200 transition">
                A10 – Server-Side Request Forgery
            </a>
        @else
            <!-- Message for guests -->
            <p class="text-md mt-8 text-red-500 font-medium">
                🔒 You must be logged in to access the OWASP demo scenarios.
            </p>
        @endauth
    </div>
</div>

<!-- Footer -->
<footer class="mt-12 text-center text-xs text-gray-500 dark:text-gray-400">
    Built with Laravel Breeze • Educational Use Only
</footer>

</body>
</html>
