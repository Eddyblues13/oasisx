@extends('layouts.admin')

@section('title', 'Edit Investment Plan - ' . config('app.name'))
@section('page-title', 'Edit Investment Plan')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.investment-plans.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Investment Plans
        </a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Edit Investment Plan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update the {{ $investmentPlan->name }} plan.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.investment-plans.update', $investmentPlan) }}" method="POST"
                class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Plan Name</label>
                        <input type="text" name="name" value="{{ old('name', $investmentPlan->name) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount
                            ($)</label>
                        <input type="number" step="0.01" name="amount"
                            value="{{ old('amount', $investmentPlan->amount) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('amount') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ROI Percentage
                            (%)</label>
                        <input type="number" step="0.01" name="roi_percentage"
                            value="{{ old('roi_percentage', $investmentPlan->roi_percentage) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('roi_percentage') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duration
                            (days)</label>
                        <input type="number" name="duration_days"
                            value="{{ old('duration_days', $investmentPlan->duration_days) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('duration_days') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">{{ old('description', $investmentPlan->description) }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active',
                        $investmentPlan->is_active) ? 'checked' : '' }}
                    class="h-4 w-4 text-black focus:ring-black dark:focus:ring-white border-gray-300 rounded">
                    <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Active (visible to
                        users)</label>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-bold rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                        Update Plan
                    </button>
                    <a href="{{ route('admin.investment-plans.index') }}"
                        class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection