@extends('layouts.admin')

@section('title', 'Investment Plans - ' . config('app.name'))
@section('page-title', 'Investment Plans')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Investment Plans</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Manage available investment plans for users.</p>
        </div>
        <a href="{{ route('admin.investment-plans.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-bold rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
            Add Plan
        </a>
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
                            Name</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Amount</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            ROI</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Duration</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($plans as $plan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $plan->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-xs">{{
                                $plan->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">${{
                            number_format($plan->amount, 2) }}</td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 dark:text-green-400">
                            {{ $plan->roi_percentage }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $plan->duration_days }} {{ Str::plural('day', $plan->duration_days) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($plan->is_active)
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                            <a href="{{ route('admin.investment-plans.edit', $plan) }}"
                                class="font-medium text-black dark:text-white hover:underline">Edit</a>
                            <form action="{{ route('admin.investment-plans.destroy', $plan) }}" method="POST"
                                class="inline" onsubmit="return confirm('Delete this plan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="font-medium text-red-600 dark:text-red-400 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No investment plans yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection