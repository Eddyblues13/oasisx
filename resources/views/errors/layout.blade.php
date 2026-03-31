<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com/"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white dark:bg-black text-gray-900 dark:text-white antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-6">
        <div class="text-center max-w-md">
            <p class="text-8xl sm:text-9xl font-bold tracking-tighter text-gray-200 dark:text-gray-800">
                @yield('code')
            </p>
            <h1 class="mt-4 text-2xl sm:text-3xl font-bold tracking-tight">
                @yield('heading')
            </h1>
            <p class="mt-3 text-gray-500 dark:text-gray-400 text-sm sm:text-base leading-relaxed">
                @yield('message')
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold bg-black text-white dark:bg-white dark:text-black hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z">
                        </path>
                    </svg>
                    Go Home
                </a>
                <button onclick="history.back()"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Go Back
                </button>
            </div>
        </div>

        <p class="mt-16 text-xs text-gray-400 dark:text-gray-600">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>
</body>

</html>