@extends('layouts.admin')

@section('title', 'Wallet Connections - ' . config('app.name'))
@section('page-title', 'Wallet Connections')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Wallet Connections</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Review and manage user wallet connections.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.wallet-connections.index') }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-black text-white dark:bg-white dark:text-black' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                All
            </a>
            <a href="{{ route('admin.wallet-connections.index', ['status' => 'pending']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Pending
            </a>
            <a href="{{ route('admin.wallet-connections.index', ['status' => 'approved']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'approved' ? 'bg-green-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Approved
            </a>
            <a href="{{ route('admin.wallet-connections.index', ['status' => 'rejected']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'rejected' ? 'bg-red-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Rejected
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            ID</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            User</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Provider</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Address</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Reward</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Date</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($connections as $connection)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">#{{
                            $connection->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $connection->user->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $connection->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $connection->provider
                                }}</span>
                            @if($connection->network)
                            <span class="block text-xs text-gray-500 dark:text-gray-400">{{ $connection->network
                                }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                            <span class="font-mono text-xs break-all">{{ Str::limit($connection->address, 30) }}</span>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 dark:text-green-400">
                            ${{ number_format($connection->daily_reward, 2) }}/day
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($connection->status === 'pending')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pending</span>
                            @elseif($connection->status === 'approved')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $connection->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.wallet-connections.show', $connection) }}"
                                class="text-sm font-medium text-black dark:text-white hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No wallet connections found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($connections->hasPages())
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
            {{ $connections->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection