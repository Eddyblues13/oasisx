{{-- Admin Sidebar --}}
<aside x-data="{ open: false }"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 transform transition-transform duration-200 ease-in-out md:translate-x-0"
    :class="open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" @sidebar-toggle.window="open = !open"
    @click.away="open = false">

    {{-- Logo --}}
    <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-gray-800">
        <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl tracking-tight">
            <span class="text-gray-900 dark:text-white">{{ config('app.name', 'OasisX') }}</span>
            <span class="text-xs font-medium text-gray-500 ml-1">Admin</span>
        </a>
        <button @click="open = false"
            class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="px-4 py-6 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Main</p>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-3">Management</p>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.users.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            Users
        </a>

        <a href="{{ route('admin.admins.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.admins.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
            </svg>
            Admins
        </a>

        <a href="{{ route('admin.payment-methods.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.payment-methods.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                </path>
            </svg>
            Payment Methods
        </a>

        <a href="{{ route('admin.deposits.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.deposits.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
            Deposits
        </a>

        <a href="{{ route('admin.withdrawals.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.withdrawals.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            Withdrawals
        </a>

        <a href="{{ route('admin.investment-plans.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.investment-plans.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
            Investment Plans
        </a>

        <a href="{{ route('admin.investments.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.investments.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            Investments
        </a>

        <a href="{{ route('admin.wallet-providers.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.wallet-providers.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
            </svg>
            Wallet Providers
        </a>

        <a href="{{ route('admin.wallet-connections.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.wallet-connections.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            Wallet Connections
        </a>

        <a href="{{ route('admin.traders.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.traders.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Traders
        </a>

        <a href="{{ route('admin.copy-trades.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.copy-trades.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
            Copy Trades
        </a>

        <a href="{{ route('admin.trading-bots.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.trading-bots.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            Trading Bots
        </a>

        <a href="{{ route('admin.bot-sessions.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.bot-sessions.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
            </svg>
            Bot Sessions
        </a>

        <a href="{{ route('admin.loans.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.loans.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2v7a3 3 0 006 0v-3m2-6h-2a2 2 0 00-2 2v3"></path>
            </svg>
            Loans
        </a>

        <a href="{{ route('admin.loan-settings.edit') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.loan-settings.*') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Loan Settings
        </a>

        {{-- Divider --}}
        <div class="border-t border-gray-200 dark:border-gray-800 my-4"></div>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Account</p>

        <a href="{{ route('admin.settings.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-black dark:bg-white text-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Settings
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Logout
            </button>
        </form>
    </nav>
</aside>

{{-- Sidebar Overlay (mobile) --}}
<div x-data x-show="false" x-cloak
    @sidebar-toggle.window="$el.style.display = ($el.style.display === 'none') ? 'block' : 'none'"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" @click="$dispatch('sidebar-toggle')">
</div>