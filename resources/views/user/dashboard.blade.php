@extends('layouts.user')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="space-y-8 pb-20 sm:pb-0">
    {{-- Welcome Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                Good {{ now()->format('H') < 12 ? 'Morning' : (now()->format('H') < 17 ? 'Afternoon' : 'Evening' ) }},
                        {{ Auth::user()->name }}
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Here's your financial overview.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content Column --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="hidden lg:grid lg:grid-cols-4 gap-4">
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-4 flex flex-col justify-between">
                    <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Wallet
                        Balance</p>
                    <p class="mt-2 text-lg sm:text-xl font-bold text-gray-900 dark:text-white">${{
                        number_format($walletBalance, 2) }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-4 flex flex-col justify-between">
                    <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Active
                        Investments</p>
                    <p class="mt-2 text-lg sm:text-xl font-bold text-gray-900 dark:text-white">${{
                        number_format($activeInvestmentsAmount, 2) }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">{{ $activeInvestmentsCount }} active
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-4 flex flex-col justify-between">
                    <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Open
                        Loans</p>
                    <p class="mt-2 text-lg sm:text-xl font-bold text-gray-900 dark:text-white">{{ $openLoansCount }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">Pending or approved</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-4 flex flex-col justify-between">
                    <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Crypto
                        Portfolio</p>
                    <p class="mt-2 text-lg sm:text-xl font-bold text-gray-900 dark:text-white">${{
                        number_format($cryptoPortfolio, 2) }}</p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-1">{{ $runningBotsCount }} bots running
                    </p>
                </div>
            </div>

            {{-- Balance Card --}}
            <div
                class="relative overflow-hidden rounded-3xl bg-black dark:bg-white text-white dark:text-black shadow-2xl p-6 sm:p-8 transition-transform hover:scale-[1.01] duration-300">
                <div
                    class="absolute top-0 right-0 -mr-20 -mt-20 h-64 w-64 rounded-full bg-gray-800 dark:bg-gray-100 opacity-20 blur-3xl">
                </div>
                <div
                    class="absolute bottom-0 left-0 -ml-20 -mb-20 h-64 w-64 rounded-full bg-gray-800 dark:bg-gray-200 opacity-20 blur-3xl">
                </div>

                <div class="relative z-10 flex flex-col justify-between h-full min-h-[200px]">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 dark:text-gray-500 text-sm font-medium tracking-wide uppercase">
                                Total Balance</p>
                            <h2 class="text-3xl sm:text-5xl font-bold mt-2 tracking-tighter">${{
                                number_format($totalBalance, 2) }}</h2>
                        </div>
                        <svg class="w-12 h-12 text-gray-500 dark:text-gray-400 opacity-50" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>

                    <div class="flex justify-between items-end mt-10">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-widest mb-1">Card
                                Holder</p>
                            <p class="font-medium tracking-wider text-sm">{{ strtoupper(Auth::user()->name) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 dark:text-gray-400 text-[10px] uppercase tracking-widest mb-1">
                                Status</p>
                            <div class="flex items-center gap-2 justify-end">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="font-medium text-sm">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Grid --}}
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="{{ route('wallet') }}"
                        class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all group">
                        <div
                            class="w-14 h-14 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-black dark:text-white mb-4 group-hover:scale-110 transition-transform border border-gray-100 dark:border-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Deposit</span>
                    </a>

                    <a href="{{ route('wallet') }}"
                        class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all group">
                        <div
                            class="w-14 h-14 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-black dark:text-white mb-4 group-hover:scale-110 transition-transform border border-gray-100 dark:border-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Withdraw</span>
                    </a>

                    <a href="{{ route('investments') }}"
                        class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all group">
                        <div
                            class="w-14 h-14 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-black dark:text-white mb-4 group-hover:scale-110 transition-transform border border-gray-100 dark:border-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Invest</span>
                    </a>

                    <a href="{{ route('profile') }}"
                        class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all group">
                        <div
                            class="w-14 h-14 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-black dark:text-white mb-4 group-hover:scale-110 transition-transform border border-gray-100 dark:border-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Profile</span>
                    </a>

                    <a href="{{ route('profile') }}"
                        class="flex flex-col items-center justify-center p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all group">
                        <div
                            class="w-14 h-14 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-black dark:text-white mb-4 group-hover:scale-110 transition-transform border border-gray-100 dark:border-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Refer &amp; Earn</span>
                    </a>
                </div>
            </div>

            {{-- Advanced Features --}}
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Advanced Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('wallet-connect') }}"
                        class="flex items-start gap-4 p-5 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all">
                        <div
                            class="w-11 h-11 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-black dark:text-white border border-gray-100 dark:border-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 5h16a2 2 0 012 2v3H2V7a2 2 0 012-2zm-2 7h20v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Wallet Connect</h4>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-black text-white dark:bg-white dark:text-black">Enabled</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Manage external wallet addresses
                                linked to your account.</p>
                        </div>
                    </a>

                    <a href="{{ route('copy-trade') }}"
                        class="flex items-start gap-4 p-5 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all">
                        <div
                            class="w-11 h-11 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-black dark:text-white border border-gray-100 dark:border-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M11 5H6a2 2 0 00-2 2v5m0 0h5m-5 0l3-3m4-4h5a2 2 0 012 2v5m0 0h-5m5 0l-3-3M9 19h6">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Copy Trade</h4>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-black text-white dark:bg-white dark:text-black">Enabled</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Follow pro strategies and mirror
                                their trades on your account.</p>
                        </div>
                    </a>

                    <a href="{{ route('bot-trading') }}"
                        class="flex items-start gap-4 p-5 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all">
                        <div
                            class="w-11 h-11 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-black dark:text-white border border-gray-100 dark:border-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 4h4v4H4V4zm6 0h4v4h-4V4zm6 0h4v4h-4V4zM4 10h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4zM4 16h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Bot Trading</h4>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-black text-white dark:bg-white dark:text-black">Enabled</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Automate trades with configurable
                                strategies when available.</p>
                        </div>
                    </a>

                    <a href="{{ route('loans') }}"
                        class="flex items-start gap-4 p-5 bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 hover:border-black dark:hover:border-white transition-all">
                        <div
                            class="w-11 h-11 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-black dark:text-white border border-gray-100 dark:border-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8c-1.657 0-3 .895-3 2v7a3 3 0 006 0v-3m2-6h-2a2 2 0 00-2 2v3"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Get Loan</h4>
                                <span
                                    class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-black text-white dark:bg-white dark:text-black">Enabled</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Borrow against your portfolio when
                                loan products are active.</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="flex justify-between items-center px-8 py-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Activity</h3>
                    <a href="{{ route('wallet') }}"
                        class="text-sm font-medium text-gray-500 hover:text-black dark:text-gray-400 dark:hover:text-white transition-colors">View
                        All</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($recentActivity as $activity)
                    <div class="flex items-center justify-between px-8 py-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center
                                    {{ $activity->icon === 'deposit' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : ($activity->icon === 'withdrawal' ? 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400' : 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400') }}">
                                @if($activity->icon === 'deposit')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                @elseif($activity->icon === 'withdrawal')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                                @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $activity->type }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->date->diffForHumans()
                                    }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">${{
                                number_format($activity->amount, 2) }}</p>
                            <p
                                class="text-xs font-medium capitalize {{ $activity->status === 'approved' || $activity->status === 'completed' || $activity->status === 'active' ? 'text-emerald-600 dark:text-emerald-400' : ($activity->status === 'rejected' || $activity->status === 'cancelled' ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400') }}">
                                {{ $activity->status }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        <p>No recent transactions.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar Column --}}
        <div class="space-y-8">
            {{-- Live Market View --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Live Market View</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Mini chart and quick trade access</p>
                    </div>
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 hidden sm:inline">Markets</span>
                </div>
                <div class="space-y-3">
                    <div>
                        <label for="dashboard-crypto-asset"
                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Asset</label>
                        <select id="dashboard-crypto-asset"
                            class="block w-full text-sm border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white">
                            <option value="1">Bitcoin (BTC)</option>
                            <option value="2">Ethereum (ETH)</option>
                            <option value="3">Tether (USDT)</option>
                            <option value="4">Binance Coin (BNB)</option>
                            <option value="5">Ripple (XRP)</option>
                            <option value="6">Solana (SOL)</option>
                            <option value="7">Cardano (ADA)</option>
                            <option value="8">Dogecoin (DOGE)</option>
                        </select>
                    </div>
                    <div
                        class="rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden h-52 bg-gray-50 dark:bg-gray-900">
                        <iframe id="dashboard-crypto-frame" src="" class="w-full h-full" frameborder="0"
                            allowtransparency="true" scrolling="no"></iframe>
                    </div>
                    <div class="pt-2 flex items-center justify-between gap-3">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-xs">$</span>
                                </div>
                                <input type="number" step="0.0001" min="0" id="dashboard-crypto-amount"
                                    class="block w-full pl-7 pr-3 py-2 text-xs border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"
                                    placeholder="Amount">
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" id="dashboard-crypto-buy"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-semibold text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-emerald-500">
                                Buy
                            </button>
                            <button type="button" id="dashboard-crypto-sell"
                                class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500">
                                Sell
                            </button>
                        </div>
                    </div>
                    <p id="dashboard-crypto-status" class="mt-2 text-[11px] text-gray-500 dark:text-gray-400"></p>
                </div>
            </div>

            {{-- Achievements --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-black text-white dark:bg-white dark:text-black flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    Achievements
                </h3>
                <div class="flex flex-wrap gap-2">
                    <span
                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white border border-gray-200 dark:border-gray-700">
                        New Member
                    </span>
                </div>
            </div>

            {{-- Notifications --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-black text-white dark:bg-white dark:text-black flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </div>
                        Notifications
                    </h3>
                </div>
                <div class="w-full text-center py-8">
                    <p class="text-sm text-gray-500 dark:text-gray-400">You're all caught up!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function() {
    var select = document.getElementById('dashboard-crypto-asset');
    var frame = document.getElementById('dashboard-crypto-frame');
    var chartAssets = {
        "1": "BINANCE:BTCUSDT",
        "2": "BINANCE:ETHUSDT",
        "3": "CRYPTOCAP:USDT",
        "4": "BINANCE:BNBUSDT",
        "5": "BINANCE:XRPUSDT",
        "6": "BINANCE:SOLUSDT",
        "7": "BINANCE:ADAUSDT",
        "8": "BINANCE:DOGEUSDT"
    };
    var amountInput = document.getElementById('dashboard-crypto-amount');
    var buyButton = document.getElementById('dashboard-crypto-buy');
    var sellButton = document.getElementById('dashboard-crypto-sell');
    var statusEl = document.getElementById('dashboard-crypto-status');
    var meta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = meta ? meta.getAttribute('content') : '';

    if (!select || !frame || !Object.keys(chartAssets).length) return;

    function buildUrl(symbol) {
        if (!symbol) return '';
        var theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        return 'https://s.tradingview.com/widgetembed/?symbol=' +
            encodeURIComponent(symbol) +
            '&interval=60&hidesidetoolbar=1&hidetoptoolbar=1&symboledit=0&saveimage=0&hideideas=1&theme=' + theme;
    }

    function updateChart() {
        var assetId = select.value;
        var symbol = chartAssets[assetId] || '';
        var url = buildUrl(symbol);
        if (url) frame.src = url;
    }

    function setStatus(message, type) {
        if (!statusEl) return;
        statusEl.textContent = message || '';
        if (!message) return;
        var baseClass = 'mt-2 text-[11px]';
        if (type === 'success') statusEl.className = baseClass + ' text-emerald-600 dark:text-emerald-400';
        else if (type === 'error') statusEl.className = baseClass + ' text-red-600 dark:text-red-400';
        else statusEl.className = baseClass + ' text-gray-500 dark:text-gray-400';
    }

    select.addEventListener('change', updateChart);
    updateChart();
})();
</script>
@endpush