@extends('layouts.admin')

@section('title', 'Investment #' . $investment->id . ' - ' . config('app.name'))
@section('page-title', 'Investment Details')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.investments.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Investments
        </a>
    </div>

    <div class="space-y-6">
        {{-- Investment Info --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div
                class="p-6 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Investment #{{ $investment->id }}</h2>
                @if($investment->status === 'active')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Active</span>
                @elseif($investment->status === 'completed')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Completed</span>
                @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Cancelled</span>
                @endif
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">User</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $investment->user->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $investment->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Plan</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $investment->plan->name ?? 'Deleted
                        Plan' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Invested Amount
                    </p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($investment->amount,
                        2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Expected Payout
                    </p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">${{
                        number_format($investment->expected_payout, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">ROI</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $investment->roi_percentage }}%</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Duration</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $investment->duration_days }} {{
                        Str::plural('day', $investment->duration_days) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Started</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $investment->created_at->format('M
                        d, Y \a\t H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Expires</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $investment->expires_at ?
                        $investment->expires_at->format('M d, Y \a\t H:i') : 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">User Balance</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">${{
                        number_format($investment->user->balance, 2) }}</p>
                </div>
                @if($investment->admin_note)
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Admin Note</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $investment->admin_note }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        @if($investment->status === 'active')
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Actions</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Note (optional
                        for complete, required for cancel)</label>
                    <textarea id="admin_note" rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white"
                        placeholder="Add a note..."></textarea>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('admin.investments.complete', $investment) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="admin_note" id="complete_note">
                        <button type="submit"
                            onclick="document.getElementById('complete_note').value = document.getElementById('admin_note').value"
                            class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Complete & Credit ${{ number_format($investment->expected_payout, 2) }}
                        </button>
                    </form>
                    <form action="{{ route('admin.investments.cancel', $investment) }}" method="POST" class="inline"
                        onsubmit="var note = document.getElementById('admin_note').value; if(!note) { alert('Please add a note explaining the cancellation.'); return false; } document.getElementById('cancel_note').value = note;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="admin_note" id="cancel_note">
                        <button type="submit"
                            class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            Cancel & Refund ${{ number_format($investment->amount, 2) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection