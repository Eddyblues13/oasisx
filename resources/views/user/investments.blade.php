@extends('layouts.user')

@section('title', 'Investments - ' . config('app.name'))

@section('content')
<div class="space-y-8 pb-20">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Investment Plans</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Grow your wealth with our tailored investment
                packages.</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 border border-gray-100 dark:border-gray-700 flex items-center gap-3">
            <div class="p-2 bg-black dark:bg-white rounded-full text-white dark:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Available
                    Balance</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white leading-none">${{
                    number_format(Auth::user()->balance, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- Crypto Ticker Widget --}}
    <div class="w-full overflow-hidden rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript"
                src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                {
                    "symbols": [
                        {"proName": "BITSTAMP:BTCUSD", "title": "Bitcoin"},
                        {"proName": "BITSTAMP:ETHUSD", "title": "Ethereum"},
                        {"description": "Tether", "proName": "BINANCE:USDTUSD"},
                        {"description": "BNB", "proName": "BINANCE:BNBUSD"},
                        {"description": "Solana", "proName": "BINANCE:SOLUSD"}
                    ],
                    "showSymbolLogo": true,
                    "isTransparent": true,
                    "displayMode": "adaptive",
                    "colorTheme": "light",
                    "locale": "en"
                }
            </script>
        </div>
    </div>

    {{-- Available Plans --}}
    @if($plans->isEmpty())
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-12 text-center">
        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6">
            </path>
        </svg>
        <p class="text-sm text-gray-500 dark:text-gray-400">No investment plans available at the moment.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
        <div class="relative group bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 overflow-hidden hover:border-black dark:hover:border-white transition-all duration-300"
            x-data="{ open: false }">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $plan->duration_days }} {{
                            Str::plural('Day', $plan->duration_days) }} Lock-in</p>
                    </div>
                    <div class="bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full">
                        <span class="text-sm font-bold text-black dark:text-white">{{ $plan->roi_percentage }}%
                            ROI</span>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-3xl font-extrabold text-gray-900 dark:text-white">${{ number_format($plan->amount, 2)
                        }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Investment Amount</p>
                </div>
                <div class="mt-4 space-y-2">
                    @if($plan->description)
                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $plan->description }}</p>
                    @endif
                    <div
                        class="px-3 py-2 rounded-xl bg-gray-50 dark:bg-gray-800 border border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Estimated payout after {{
                            $plan->duration_days }} {{ Str::plural('day', $plan->duration_days) }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">${{
                            number_format($plan->expected_payout, 2) }}</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="button" @click="open = true"
                        class="w-full bg-black dark:bg-white text-white dark:text-black py-3 rounded-xl font-bold hover:opacity-90 transition-opacity shadow-lg">
                        Invest Now
                    </button>
                </div>
            </div>

            {{-- Confirmation Modal --}}
            <div x-show="open" x-cloak
                class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60">
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-sm w-full mx-4 border border-gray-100 dark:border-gray-800">
                    <div
                        class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Confirm Investment</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            @click="open = false">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="px-5 py-4 space-y-2">
                        <p class="text-sm text-gray-700 dark:text-gray-200">You are about to invest in the <span
                                class="font-semibold">{{ $plan->name }}</span> plan.</p>
                        <ul class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                            <li>Amount: <span class="font-semibold text-gray-900 dark:text-white">${{
                                    number_format($plan->amount, 2) }}</span></li>
                            <li>Return: <span class="font-semibold text-gray-900 dark:text-white">{{
                                    $plan->roi_percentage }}% ROI</span></li>
                            <li>Duration: <span class="font-semibold text-gray-900 dark:text-white">{{
                                    $plan->duration_days }} {{ Str::plural('day', $plan->duration_days) }}</span></li>
                            <li>Payout: <span class="font-semibold text-green-600 dark:text-green-400">${{
                                    number_format($plan->expected_payout, 2) }}</span></li>
                        </ul>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Your balance will be deducted immediately. You'll receive ${{
                            number_format($plan->expected_payout, 2) }} when the investment completes.
                        </p>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex justify-end space-x-3">
                        <button type="button"
                            class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800"
                            @click="open = false">Cancel</button>
                        <form action="{{ route('investments.invest') }}" method="POST">
                            @csrf
                            <input type="hidden" name="investment_plan_id" value="{{ $plan->id }}">
                            <button type="submit"
                                class="px-4 py-1.5 text-xs font-semibold rounded-lg bg-black text-white dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200">
                                Confirm Investment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- My Portfolio --}}
    <div class="mt-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">My Portfolio</h3>
        <div
            class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Plan</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Amount</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Payout</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Start Date</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Expires</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse($myInvestments as $investment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{
                                    $investment->plan->name ?? 'N/A' }}</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $investment->roi_percentage }}%
                                    ROI &middot; {{ $investment->duration_days }}d</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">${{
                                number_format($investment->amount, 2) }}</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 dark:text-green-400">
                                ${{ number_format($investment->expected_payout, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($investment->status === 'active')
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Active</span>
                                @elseif($investment->status === 'completed')
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Completed</span>
                                @else
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                                $investment->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                                $investment->expires_at ? $investment->expires_at->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No investments yet. Start investing today!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection