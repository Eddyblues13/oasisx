<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<script>if(localStorage.getItem('theme')!=='light'){document.documentElement.classList.add('dark')}</script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - ' . config('app.name', 'OasisX'))</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#171717',
                        secondary: '#64748b',
                        dark: '#000000',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
        }

        .dark .glass {
            background: rgba(0, 0, 0, 0.8);
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-black text-gray-900 dark:text-white antialiased">

    {{-- Preloader --}}
    <div id="preloader"
        class="fixed inset-0 z-[100] bg-white dark:bg-black flex items-center justify-center transition-opacity duration-500">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-black dark:border-white mb-4"></div>
            <div class="text-sm font-medium text-gray-900 dark:text-white animate-pulse">Loading...</div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0');
            setTimeout(() => { preloader.style.display = 'none'; }, 500);
        });
    </script>

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen md:ml-64">

            {{-- Top Navigation --}}
            @include('admin.partials.navbar')

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                <div
                    class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            {{-- Content --}}
            <main class="flex-1">
                <div class="max-w-7xl mx-auto py-6 px-4 pb-24 md:pb-6 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>

    </div>

    @stack('scripts')
</body>

</html>