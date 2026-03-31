@extends('layouts.admin')

@section('title', 'Wallet Connection #' . $walletConnection->id . ' - ' . config('app.name'))
@section('page-title', 'Wallet Connection Details')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.wallet-connections.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Wallet Connections
        </a>
    </div>

    <div class="space-y-6">
        {{-- Connection Info --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Wallet Connection #{{ $walletConnection->id
                    }}</h2>
                @if($walletConnection->status === 'pending')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pending</span>
                @elseif($walletConnection->status === 'approved')
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
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $walletConnection->user->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $walletConnection->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Provider</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $walletConnection->provider }}</p>
                </div>
                @if($walletConnection->network)
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Network</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $walletConnection->network }}</p>
                </div>
                @endif
                @if($walletConnection->label)
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Label</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $walletConnection->label }}</p>
                </div>
                @endif
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Wallet Address</p>
                    <p
                        class="text-sm font-mono text-gray-900 dark:text-white break-all bg-gray-50 dark:bg-gray-700/50 px-3 py-2 rounded-lg">
                        {{ $walletConnection->address }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Daily Reward</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">${{
                        number_format($walletConnection->daily_reward, 2) }}/day</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Submitted</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{
                        $walletConnection->created_at->format('M d, Y \a\t H:i') }}</p>
                </div>
                @if($walletConnection->admin_note)
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Admin Note</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $walletConnection->admin_note }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        @if($walletConnection->status === 'pending')
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Actions</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Daily Reward Amount
                        ($)</label>
                    <input type="number" id="daily_reward" step="0.01" min="0" value="0"
                        class="w-full sm:w-48 px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white"
                        placeholder="e.g. 50.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Note
                        (optional)</label>
                    <textarea id="admin_note" rows="2"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white"
                        placeholder="Add a note..."></textarea>
                </div>
                <div class="flex gap-3">
                    <form action="{{ route('admin.wallet-connections.approve', $walletConnection) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="daily_reward" id="approve_reward">
                        <input type="hidden" name="admin_note" id="approve_note">
                        <button type="submit"
                            onclick="document.getElementById('approve_reward').value = document.getElementById('daily_reward').value; document.getElementById('approve_note').value = document.getElementById('admin_note').value;"
                            class="px-6 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            Approve Wallet
                        </button>
                    </form>
                    <form action="{{ route('admin.wallet-connections.reject', $walletConnection) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="admin_note" id="reject_note">
                        <button type="submit"
                            onclick="document.getElementById('reject_note').value = document.getElementById('admin_note').value;"
                            class="px-6 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Delete --}}
        <div class="flex justify-end">
            <form action="{{ route('admin.wallet-connections.destroy', $walletConnection) }}" method="POST"
                onsubmit="return confirm('Delete this wallet connection permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:underline">Delete this
                    connection</button>
            </form>
        </div>
    </div>
</div>
@endsection