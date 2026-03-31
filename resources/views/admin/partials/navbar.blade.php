{{-- Admin Top Navbar --}}
<nav class="glass sticky top-0 z-30 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- Mobile menu toggle --}}
                <button @click="$dispatch('sidebar-toggle')"
                    class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">@yield('page-title', 'Dashboard')</h2>
            </div>

            <div class="flex items-center gap-4">
                {{-- Admin badge --}}
                <span
                    class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-black text-white dark:bg-white dark:text-black">
                    Admin
                </span>

                {{-- Dark Mode Toggle --}}
                <button type="button"
                    onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                    class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </button>

                {{-- Admin name --}}
                <div class="flex items-center gap-3">
                    <div class="hidden md:block text-right">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{
                            Auth::guard('admin')->user()->name }}</div>
                        <div class="text-xs text-gray-500">Administrator</div>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-black dark:bg-white flex items-center justify-center">
                        <span class="text-sm font-bold text-white dark:text-black">{{
                            strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>