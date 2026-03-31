@extends('layouts.user')

@section('title', 'Loans - ' . config('app.name'))

@section('content')
<div class="space-y-8 pb-20 sm:pb-0">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Loans</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Borrow against your portfolio when loan products are
                active.</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Wallet Balance</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format(auth()->user()->balance, 2) }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
        <div class="lg:col-span-2 space-y-6">
            {{-- Overview --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Overview</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Loan products let you borrow against your wallet balance within configured limits.
                    The exact rules, collateral requirements, and repayment schedules are controlled
                    from the admin panel.
                </p>
            </div>

            {{-- Loan Limits --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Your Loan Limits</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1 font-semibold">
                            @if($settings->is_enabled)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-black text-white dark:bg-white dark:text-black">Enabled</span>
                            @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200">Disabled</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Max Open Loans</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $settings->max_open_loans }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Max LTV</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{
                            number_format($settings->max_ltv, 0) }}%</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Daily Interest Rate</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{
                            number_format($settings->daily_interest_rate, 2) }}%</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Estimated Max Borrowable</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-white">${{ number_format($maxBorrowable,
                            2) }}</dd>
                    </div>
                </dl>

                @if($canApply)
                <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                    You can request a new loan below if you are within your limits.
                </p>
                @endif
            </div>

            {{-- Request a Loan --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Request a Loan</h2>

                @if($canApply)
                <form action="{{ route('loans.apply') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Loan
                            Amount ($)</label>
                        <input type="number" name="amount" id="amount" step="0.01" min="1" max="{{ $maxBorrowable }}"
                            value="{{ old('amount') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm py-2.5"
                            placeholder="Max ${{ number_format($maxBorrowable, 2) }}">
                        @error('amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-black dark:bg-white text-white dark:text-black py-2.5 rounded-xl text-sm font-bold hover:opacity-90 transition-opacity shadow-lg">
                        Submit Loan Request
                    </button>
                </form>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if(!$settings->is_enabled)
                    Loans are currently disabled.
                    @else
                    You have reached the maximum number of open loans.
                    @endif
                </p>
                @endif
            </div>

            {{-- Loan History --}}
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Your Loan Requests</h2>

                @if($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Amount</th>
                                <th
                                    class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Admin Note</th>
                                <th
                                    class="px-4 py-2 text-left font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Outstanding</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($loans as $loan)
                            <tr>
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-200">{{
                                    $loan->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-200">${{ number_format($loan->amount,
                                    2) }}</td>
                                <td class="px-4 py-2">
                                    @if($loan->status === 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Pending</span>
                                    @elseif($loan->status === 'approved')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                                    @elseif($loan->status === 'rejected')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                                    @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200">Repaid</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300 text-xs">{{ $loan->admin_note ??
                                    '—' }}</td>
                                <td class="px-4 py-2 text-gray-700 dark:text-gray-200 text-xs">
                                    {{ $loan->outstanding_amount ? '$' . number_format($loan->outstanding_amount, 2) :
                                    '—' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">You have no loan requests yet.</p>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-5">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">Important Notes</h3>
                <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                    <li>Borrowing limits depend on your wallet balance and configured LTV.</li>
                    <li>Interest is charged daily based on the outstanding loan amount.</li>
                    <li>Defaulting on repayments may result in collateral being used to cover the loan.</li>
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