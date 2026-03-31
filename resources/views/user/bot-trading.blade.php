@extends('layouts.user')

@section('title', 'Bot Trading - ' . config('app.name'))

@section('content')
<div class="space-y-8 pb-20 sm:pb-0">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Bot Trading</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Automate trading with configurable strategies when this
                feature is enabled.</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Wallet Balance</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format(auth()->user()->balance, 2) }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
        <div class="lg:col-span-2 space-y-6">
            {{-- Available Bots --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Available Bots</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($bots as $bot)
                    <div
                        class="relative group bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden hover:border-black dark:hover:border-white transition-all duration-300">
                        <div class="p-5">
                            <div class="flex justify-between items-start gap-3">
                                <div class="flex items-center gap-3">
                                    @if($bot->image)
                                    <img src="{{ $bot->image }}" alt="{{ $bot->name }}"
                                        class="w-10 h-10 rounded-xl object-cover border border-gray-200 dark:border-gray-700">
                                    @else
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    @endif
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $bot->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{
                                            $bot->runtime_hours }} {{ Str::plural('Hour', $bot->runtime_hours) }}
                                            Runtime</p>
                                    </div>
                                </div>
                                <div class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full">
                                    <span class="text-xs font-bold text-black dark:text-white">{{
                                        number_format($bot->hourly_roi, 2) }}% Return</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Stake Range</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($bot->min_amount, 2) }}
                                    @if($bot->max_amount)
                                    - ${{ number_format($bot->max_amount, 2) }}
                                    @endif
                                </p>
                            </div>

                            <div class="mt-3 space-y-2">
                                @if($bot->description)
                                <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2">{{ $bot->description }}
                                </p>
                                @endif
                                <div
                                    class="px-3 py-2 rounded-xl bg-gray-50 dark:bg-gray-800 border border-dashed border-gray-200 dark:border-gray-700">
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Rewards are paid hourly
                                        based on your staked amount.</p>
                                    <p class="text-xs font-semibold text-gray-900 dark:text-white">ROI per hour: {{
                                        number_format($bot->hourly_roi, 2) }}%</p>
                                </div>
                            </div>

                            @php
                            $alreadyRunning = $runningSessions->where('trading_bot_id', $bot->id)->first();
                            @endphp

                            @if($alreadyRunning)
                            <div class="mt-4">
                                <div
                                    class="w-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 py-2.5 rounded-xl text-sm font-bold text-center">
                                    Bot Running
                                </div>
                            </div>
                            @else
                            <div x-data="{ open: false }" class="mt-4">
                                <form x-ref="startForm" action="{{ route('bot-trading.start', $bot) }}" method="POST"
                                    class="space-y-3">
                                    @csrf
                                    <div>
                                        <label
                                            class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Amount
                                            to Stake ($)</label>
                                        <input type="number" name="amount" step="0.01" min="{{ $bot->min_amount }}"
                                            @if($bot->max_amount) max="{{ $bot->max_amount }}" @endif
                                        class="focus:ring-black focus:border-black dark:focus:ring-white
                                        dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg
                                        dark:bg-gray-800 dark:border-gray-700 dark:text-white py-2.5"
                                        placeholder="Between ${{ number_format($bot->min_amount, 2) }}{{
                                        $bot->max_amount ? ' and $' . number_format($bot->max_amount, 2) : '+' }}">
                                    </div>
                                    <button type="button" @click="open = true"
                                        class="w-full bg-black dark:bg-white text-white dark:text-black py-2.5 rounded-xl text-sm font-bold hover:opacity-90 transition-opacity shadow-lg">
                                        Start Bot
                                    </button>
                                </form>

                                {{-- Confirm Modal --}}
                                <div x-show="open" x-cloak
                                    class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60">
                                    <div
                                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-sm w-full mx-4 border border-gray-100 dark:border-gray-800">
                                        <div
                                            class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Confirm Bot
                                                Start</h3>
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                @click="open = false">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="px-5 py-4 space-y-2">
                                            <p class="text-sm text-gray-700 dark:text-gray-200">
                                                You are about to start the <span class="font-semibold">{{ $bot->name
                                                    }}</span> trading bot.
                                            </p>
                                            <p class="text-[11px] text-gray-500 dark:text-gray-400">
                                                Ensure your stake amount is within the allowed range before confirming.
                                            </p>
                                        </div>
                                        <div
                                            class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex justify-end space-x-3">
                                            <button type="button"
                                                class="px-3 py-1.5 text-[11px] font-medium rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800"
                                                @click="open = false">
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="px-4 py-1.5 text-[11px] font-semibold rounded-lg bg-black text-white dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200"
                                                @click="$refs.startForm.submit()">
                                                Confirm Start
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No trading bots available at the moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Running Bots --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">My Running Bots</h2>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $runningSessions->count() }} / {{ $maxBots
                        }} running</span>
                </div>

                @if($runningSessions->count() > 0)
                <div class="space-y-4">
                    @foreach($runningSessions as $session)
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                @if($session->tradingBot->image)
                                <img src="{{ $session->tradingBot->image }}" alt=""
                                    class="w-8 h-8 rounded-lg object-cover">
                                @endif
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{
                                        $session->tradingBot->name }}</h4>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400">Started {{
                                        $session->started_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div x-data="{ confirmStop: false }">
                                <button @click="confirmStop = true"
                                    class="px-3 py-1 text-xs font-semibold rounded-lg bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                                    Stop Bot
                                </button>
                                <div x-show="confirmStop" x-cloak
                                    class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60">
                                    <div
                                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-sm w-full mx-4 border border-gray-100 dark:border-gray-800">
                                        <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Stop Bot?
                                            </h3>
                                        </div>
                                        <div class="px-5 py-4">
                                            <p class="text-sm text-gray-700 dark:text-gray-200">
                                                Stop <span class="font-semibold">{{ $session->tradingBot->name
                                                    }}</span>? Your staked amount of ${{ number_format($session->amount,
                                                2) }} will be refunded.
                                            </p>
                                        </div>
                                        <div
                                            class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex justify-end space-x-3">
                                            <button type="button"
                                                class="px-3 py-1.5 text-[11px] font-medium rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200"
                                                @click="confirmStop = false">Cancel</button>
                                            <form action="{{ route('bot-trading.stop', $session) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-4 py-1.5 text-[11px] font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700">Stop
                                                    Bot</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">Staked</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">${{
                                    number_format($session->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">ROI/Hour</p>
                                <p class="text-sm font-bold text-green-600 dark:text-green-400">{{
                                    number_format($session->tradingBot->hourly_roi, 2) }}%</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400">Runtime</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{
                                    $session->tradingBot->runtime_hours }}h</p>
                            </div>
                        </div>
                        {{-- Bot Terminal --}}
                        <div
                            class="mt-3 bot-terminal bg-black rounded-lg p-3 font-mono text-[10px] text-green-400 overflow-hidden h-20">
                            <div class="bot-terminal-lines space-y-0.5">
                                <p>Initializing {{ $session->tradingBot->name }}...</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">You have no bot sessions yet. Start a bot above to
                    see live activity.</p>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Bot Trading Basics</h3>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <li>Bots open and close simulated positions based on configured rules.</li>
                    <li>Stake is locked until the bot session completes.</li>
                    <li>Returns use the same processing engine as investment plans.</li>
                </ul>
            </div>

            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Limits</h3>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    Max bots per user: <span class="font-semibold text-gray-900 dark:text-white">{{ $maxBots }}</span>
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-bold rounded-lg border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Back to Dashboard
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
    function randomFrom(arr) {
        return arr[Math.floor(Math.random() * arr.length)];
    }

    var samples = [
        function () {
            var side = Math.random() > 0.5 ? 'BUY' : 'SELL';
            var size = (Math.random() * 0.5 + 0.1).toFixed(3);
            var price = (Math.random() * 50 + 1500).toFixed(2);
            var pnl = (Math.random() * 4 - 2).toFixed(2);
            var sign = pnl >= 0 ? '+' : '';
            return '[' + new Date().toLocaleTimeString([], {hour12:false}) + '] ' + side + ' ' + size + ' BTC @ ' + price + ' | PnL ' + sign + pnl + '%';
        },
        function () {
            var symbols = ['ETH/USDT', 'BTC/USDT', 'SOL/USDT', 'BNB/USDT'];
            var symbol = randomFrom(symbols);
            var change = (Math.random() * 3 - 1.5).toFixed(2);
            var dir = change >= 0 ? '↑' : '↓';
            return 'Signal ' + symbol + ' ' + dir + ' ' + change + '%, adjusting exposure...';
        },
        function () {
            var risk = (Math.random() * 1.5 + 0.5).toFixed(2);
            return 'Rebalancing positions, target risk: ' + risk + '% of equity.';
        }
    ];

    var terminals = document.querySelectorAll('.bot-terminal');
    terminals.forEach(function (terminal) {
        var container = terminal.querySelector('.bot-terminal-lines');
        if (!container) return;

        function tick() {
            var line = document.createElement('p');
            line.textContent = randomFrom(samples)();
            container.appendChild(line);

            while (container.children.length > 5) {
                container.removeChild(container.firstChild);
            }

            setTimeout(tick, 1200 + Math.random() * 1500);
        }

        setTimeout(tick, 1500 + Math.random() * 1500);
    });
})();
</script>
@endpush
@endsection