@extends('layouts.admin')

@section('title', 'Admin Dashboard - ' . config('app.name'))
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Welcome --}}
    <div>
        <h1 class="text-2xl sm:text-2xl text-3xl font-bold text-gray-900 dark:text-white">Welcome back, {{
            Auth::guard('admin')->user()->name
            }}</h1>
        <p class="text-gray-500 dark:text-gray-400 text-base sm:text-sm">Here's an overview of your platform.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 sm:p-6 shadow-sm">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 sm:p-6 shadow-sm">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white truncate">${{
                number_format($totalDeposits, 2) }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Deposits</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 sm:p-6 shadow-sm">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">0</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Active Investments</p>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 sm:p-6 shadow-sm">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingDeposits }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pending Deposits</p>
        </div>
    </div>

    {{-- Recent Users --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Users</h3>
            <a href="{{ route('admin.users.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                View all &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            User</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Joined</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentUsers as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-sm font-bold text-gray-500 dark:text-gray-400">{{
                                        strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $user->email
                            }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.users.show', $user) }}"
                                class="text-sm font-medium text-gray-600 hover:text-black dark:text-gray-400 dark:hover:text-white">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No users
                            yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection