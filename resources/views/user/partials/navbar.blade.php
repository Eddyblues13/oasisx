{{-- User Dashboard Navigation --}}
<nav class="glass sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-bold text-2xl text-primary tracking-tight">
                        <span class="text-gray-900 dark:text-white">{{ config('app.name', 'OasisX') }}</span>
                    </a>
                </div>
                <div class="hidden md:ml-8 md:flex md:space-x-8">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('dashboard') ? 'border-black text-black dark:border-white dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('wallet') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('wallet') ? 'border-black text-black dark:border-white dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Wallet
                    </a>
                    <a href="{{ route('investments') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('investments') ? 'border-black text-black dark:border-white dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Invest
                    </a>
                    <a href="{{ route('wallet-connect') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('wallet-connect*') ? 'border-black text-black dark:border-white dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Connect
                    </a>
                    <a href="{{ route('profile') }}"
                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                       {{ request()->routeIs('profile') ? 'border-black text-black dark:border-white dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200' }}">
                        Profile
                    </a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="ml-3 relative flex items-center gap-4">
                    {{-- Balance Pill --}}
                    <div class="hidden md:flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-sm font-bold text-green-700 dark:text-green-400">
                            $0.00
                        </span>
                    </div>

                    {{-- Dark Mode Toggle --}}
                    <button type="button"
                        onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                        class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                        {{-- Moon icon (shown in light mode) --}}
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        {{-- Sun icon (shown in dark mode) --}}
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </button>

                    {{-- User Menu --}}
                    <div class="relative ml-3 flex items-center gap-3">
                        <div class="hidden md:block text-right">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>