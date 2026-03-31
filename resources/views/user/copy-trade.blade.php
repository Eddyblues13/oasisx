@extends('layouts.user')

@section('title', 'Copy Trading - ' . config('app.name'))

@section('content')
<div class="space-y-8 pb-20 sm:pb-0">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                Copy Trading
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">
                Follow professional strategies and mirror their trades on your account when available.
            </p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Wallet Balance</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">
                ${{ number_format(Auth::user()->balance, 2) }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
        <div class="lg:col-span-2 space-y-6">
            {{-- Overview --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Overview</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1 font-semibold">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-black text-white dark:bg-white dark:text-black">
                                Enabled
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Max Strategies</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $maxStrategies }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Active Strategies</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $activeTrades->count() }}</dd>
                    </div>
                </dl>
                <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                    Choose a trader below, enter the amount you want to allocate, and start copy trading.
                    You can stop any strategy at any time and your stake will return to your wallet.
                </p>
            </div>

            {{-- Available Strategies --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Available Strategies</h2>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $traders->count() }} available</span>
                </div>

                @if($traders->count())
                <div class="space-y-4">
                    @foreach($traders as $trader)
                    @php
                    $alreadyCopying = $activeTrades->contains('trader_id', $trader->id);
                    @endphp
                    <div class="border border-gray-100 dark:border-gray-800 rounded-xl p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                @if($trader->avatar)
                                <img src="{{ $trader->avatar }}" alt="{{ $trader->trader_name }}"
                                    class="w-9 h-9 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                @else
                                <div
                                    class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-300">
                                    {{ strtoupper(substr($trader->trader_name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $trader->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">By {{
                                        $trader->trader_name }}</p>
                                    @if($trader->description)
                                    <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">{{ $trader->description }}
                                    </p>
                                    @endif
                                    <div class="mt-2 flex flex-wrap items-center gap-2 text-[11px]">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                            Daily {{ number_format($trader->daily_roi, 2) }}%
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                            Min ${{ number_format($trader->min_amount, 2) }}
                                            @if($trader->max_amount)
                                            - Max ${{ number_format($trader->max_amount, 2) }}
                                            @endif
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                            Risk: {{ ucfirst($trader->risk_level) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Strategy ID #{{ $trader->id }}</p>
                            </div>
                        </div>

                        @if($alreadyCopying)
                        <div
                            class="mt-3 flex items-center gap-2 text-xs text-green-600 dark:text-green-400 font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Already following this strategy
                        </div>
                        @else
                        <form action="{{ route('copy-trade.subscribe', $trader) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="flex items-center gap-3">
                                <div class="flex-1">
                                    <input type="number" name="amount" step="0.01" min="{{ $trader->min_amount }}"
                                        @if($trader->max_amount) max="{{ $trader->max_amount }}" @endif
                                    placeholder="Amount to allocate"
                                    class="block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-lg text-sm
                                    focus:outline-none focus:ring-black focus:border-black dark:bg-gray-800
                                    dark:border-gray-700 dark:text-white">
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-bold bg-black text-white dark:bg-white dark:text-black hover:opacity-90 transition-opacity">
                                    Start Copy
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No strategies available at the moment.</p>
                @endif
            </div>

            {{-- Active Copy Trades --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Your Active Copy Trades</h2>

                @if($activeTrades->count())
                <div class="space-y-4">
                    @foreach($activeTrades as $trade)
                    <div
                        class="border border-gray-100 dark:border-gray-800 rounded-xl p-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            @if($trade->trader->avatar)
                            <img src="{{ $trade->trader->avatar }}" alt="{{ $trade->trader->trader_name }}"
                                class="w-9 h-9 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                            @else
                            <div
                                class="w-9 h-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-300">
                                {{ strtoupper(substr($trade->trader->trader_name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $trade->trader->name
                                    }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    ${{ number_format($trade->amount, 2) }} allocated &middot; {{
                                    number_format($trade->trader->daily_roi, 2) }}%/day
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Started {{
                                    $trade->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <form action="{{ route('copy-trade.unsubscribe', $trade) }}" method="POST"
                            onsubmit="return confirm('Stop following this strategy? ${{ number_format($trade->amount, 2) }} will be returned to your wallet.')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-3 py-1.5 text-xs font-bold border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                Stop
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">You are not following any strategies yet.</p>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">How Copy Trading Works</h3>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <li>Choose one or more strategies within your allowed limit.</li>
                    <li>Your trades follow the selected strategies in proportion to your balance.</li>
                    <li>You can stop following a strategy at any time.</li>
                </ul>
            </div>

            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-bold rounded-lg border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection