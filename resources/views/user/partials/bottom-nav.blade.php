{{-- Mobile Bottom Navigation --}}
<div
    class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-black border-t border-gray-200 dark:border-gray-800 z-50 pb-safe">
    <div class="flex justify-around items-center p-1">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'text-black dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            <span class="text-xs font-medium">Home</span>
        </a>
        <a href="{{ route('wallet') }}"
            class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('wallet') ? 'text-black dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <span class="text-xs font-medium">Wallet</span>
        </a>
        <a href="{{ route('investments') }}"
            class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('investments') ? 'text-black dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span class="text-xs font-medium">Invest</span>
        </a>
        <a href="{{ route('wallet-connect') }}"
            class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('wallet-connect*') ? 'text-black dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            <span class="text-xs font-medium">Connect</span>
        </a>
        <a href="{{ route('profile') }}"
            class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('profile') ? 'text-black dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-xs font-medium">Profile</span>
        </a>
    </div>
</div>