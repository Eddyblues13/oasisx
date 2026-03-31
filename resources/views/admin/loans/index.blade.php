@extends('layouts.admin')

@section('title', 'Loans - ' . config('app.name'))
@section('page-title', 'Loans')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Loans</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">View and manage user loan requests.</p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.loans.index') }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-black text-white dark:bg-white dark:text-black' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                All
            </a>
            <a href="{{ route('admin.loans.index', ['status' => 'pending']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Pending
            </a>
            <a href="{{ route('admin.loans.index', ['status' => 'approved']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'approved' ? 'bg-green-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Approved
            </a>
            <a href="{{ route('admin.loans.index', ['status' => 'rejected']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'rejected' ? 'bg-red-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Rejected
            </a>
            <a href="{{ route('admin.loans.index', ['status' => 'repaid']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'repaid' ? 'bg-gray-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Repaid
            </a>
        </div>
    </div>

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
                            Amount</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Outstanding</th>
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
                    @forelse($loans as $loan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">#{{ $loan->id
                            }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $loan->user->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $loan->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">${{
                            number_format($loan->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $loan->outstanding_amount ? '$' . number_format($loan->outstanding_amount, 2) : '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($loan->status === 'pending')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Pending</span>
                            @elseif($loan->status === 'approved')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                            @elseif($loan->status === 'rejected')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200">Repaid</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $loan->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('admin.loans.show', $loan) }}"
                                class="text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No loans found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($loans->hasPages())
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
            {{ $loans->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection