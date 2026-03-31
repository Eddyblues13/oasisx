@extends('layouts.admin')

@section('title', 'Withdrawal #' . $withdrawal->id . ' - ' . config('app.name'))
@section('page-title', 'Withdrawal Details')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.withdrawals.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Withdrawals
        </a>
    </div>

    <div class="space-y-6">
        {{-- Withdrawal Info --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Withdrawal #{{ $withdrawal->id }}</h2>
                @if($withdrawal->status === 'pending')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pending
                    Review</span>
                @elseif($withdrawal->status === 'approved')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                @endif
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">User</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $withdrawal->user->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $withdrawal->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Amount</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($withdrawal->amount,
                        2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Withdrawal Method
                    </p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $withdrawal->method }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Date</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $withdrawal->created_at->format('M
                        d, Y \a\t H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">User Balance</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">${{
                        number_format($withdrawal->user->balance, 2) }}</p>
                </div>
                @if($withdrawal->details)
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">User Details /
                        Wallet Address</p>
                    <p
                        class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 font-mono break-all">
                        {{ $withdrawal->details }}</p>
                </div>
                @endif
                @if($withdrawal->admin_note)
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Admin Note</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->admin_note }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        @if($withdrawal->status === 'pending')
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Actions</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Note (optional
                        for approve, required for reject)</label>
                    <textarea id="admin_note" rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white"
                        placeholder="Add a note..."></textarea>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="admin_note" id="approve_note">
                        <button type="submit"
                            onclick="document.getElementById('approve_note').value = document.getElementById('admin_note').value"
                            class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Approve Withdrawal
                        </button>
                    </form>
                    <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST" class="inline"
                        onsubmit="var note = document.getElementById('admin_note').value; if(!note) { alert('Please add a note explaining the rejection.'); return false; } document.getElementById('reject_note').value = note;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="admin_note" id="reject_note">
                        <button type="submit"
                            class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            Reject & Refund Balance
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection