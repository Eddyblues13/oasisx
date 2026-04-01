@extends('layouts.admin')

@section('title', 'Bot Sessions - ' . config('app.name'))
@section('page-title', 'Bot Sessions')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bot Sessions</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">View all user bot trading sessions.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.bot-sessions.index') }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-black text-white dark:bg-white dark:text-black' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                All
            </a>
            <a href="{{ route('admin.bot-sessions.index', ['status' => 'running']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'running' ? 'bg-green-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Running
            </a>
            <a href="{{ route('admin.bot-sessions.index', ['status' => 'stopped']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'stopped' ? 'bg-red-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Stopped
            </a>
            <a href="{{ route('admin.bot-sessions.index', ['status' => 'completed']) }}"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'completed' ? 'bg-blue-500 text-white' : 'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                Completed
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
                            Bot</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Staked</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Started</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($botSessions as $session)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">#{{
                            $session->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->user->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $session->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if($session->tradingBot->image)
                                <img src="{{ $session->tradingBot->image }}" alt=""
                                    class="w-6 h-6 rounded-lg object-cover">
                                @endif
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{
                                    $session->tradingBot->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">${{
                            number_format($session->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($session->status === 'running')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Running</span>
                            @elseif($session->status === 'completed')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Completed</span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Stopped</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $session->started_at ? $session->started_at->format('M d, Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No bot sessions found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($botSessions->hasPages())
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
            {{ $botSessions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection