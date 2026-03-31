@extends('layouts.admin')

@section('title', 'Loan #' . $loan->id . ' - ' . config('app.name'))
@section('page-title', 'Loan Details')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Loan #{{ $loan->id }}</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Submitted {{ $loan->created_at->format('M d, Y H:i') }}
            </p>
        </div>
        <a href="{{ route('admin.loans.index') }}"
            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">&larr; Back to
            Loans</a>
    </div>

    {{-- Loan Info --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Loan Information</h2>
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500 dark:text-gray-400">User</dt>
                <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $loan->user->name }}</dd>
                <dd class="text-xs text-gray-500 dark:text-gray-400">{{ $loan->user->email }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 dark:text-gray-400">User Balance</dt>
                <dd class="mt-1 font-semibold text-gray-900 dark:text-white">${{ number_format($loan->user->balance, 2)
                    }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Loan Amount</dt>
                <dd class="mt-1 font-semibold text-gray-900 dark:text-white">${{ number_format($loan->amount, 2) }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Outstanding</dt>
                <dd class="mt-1 font-semibold text-gray-900 dark:text-white">{{ $loan->outstanding_amount ? '$' .
                    number_format($loan->outstanding_amount, 2) : '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                <dd class="mt-1">
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
                </dd>
            </div>
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Admin Note</dt>
                <dd class="mt-1 text-gray-900 dark:text-white text-sm">{{ $loan->admin_note ?? '—' }}</dd>
            </div>
            @if($loan->approved_at)
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Approved At</dt>
                <dd class="mt-1 text-gray-900 dark:text-white">{{ $loan->approved_at->format('M d, Y H:i') }}</dd>
            </div>
            @endif
            @if($loan->repaid_at)
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Repaid At</dt>
                <dd class="mt-1 text-gray-900 dark:text-white">{{ $loan->repaid_at->format('M d, Y H:i') }}</dd>
            </div>
            @endif
        </dl>
    </div>

    {{-- Actions --}}
    @if($loan->status === 'pending')
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Approve --}}
            <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" class="space-y-3">
                @csrf
                @method('PATCH')
                <div>
                    <label for="approve_note"
                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Note
                        (optional)</label>
                    <textarea name="admin_note" id="approve_note" rows="2"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"></textarea>
                </div>
                <button type="submit"
                    class="w-full px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                    Approve Loan
                </button>
            </form>

            {{-- Reject --}}
            <form action="{{ route('admin.loans.reject', $loan) }}" method="POST" class="space-y-3">
                @csrf
                @method('PATCH')
                <div>
                    <label for="reject_note"
                        class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Note
                        (optional)</label>
                    <textarea name="admin_note" id="reject_note" rows="2"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"></textarea>
                </div>
                <button type="submit"
                    class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Reject Loan
                </button>
            </form>
        </div>
    </div>
    @endif

    @if($loan->status === 'approved')
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h2>
        <form action="{{ route('admin.loans.repaid', $loan) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
                class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity"
                onclick="return confirm('Mark this loan as repaid?')">
                Mark as Repaid
            </button>
        </form>
    </div>
    @endif
</div>
@endsection