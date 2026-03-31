@extends('layouts.admin')

@section('title', 'Loan Settings - ' . config('app.name'))
@section('page-title', 'Loan Settings')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Loan Settings</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Configure global loan parameters for all users.</p>
    </div>

    <form action="{{ route('admin.loan-settings.update') }}" method="POST"
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="max_open_loans" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max
                    Open Loans Per User</label>
                <input type="number" name="max_open_loans" id="max_open_loans"
                    value="{{ old('max_open_loans', $settings->max_open_loans) }}" min="1" max="10" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
                @error('max_open_loans') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="max_ltv" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max LTV
                    (%)</label>
                <input type="number" name="max_ltv" id="max_ltv" value="{{ old('max_ltv', $settings->max_ltv) }}"
                    step="0.01" min="1" max="100" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
                @error('max_ltv') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="daily_interest_rate"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Daily Interest Rate (%)</label>
            <input type="number" name="daily_interest_rate" id="daily_interest_rate"
                value="{{ old('daily_interest_rate', $settings->daily_interest_rate) }}" step="0.01" min="0.01"
                max="100" required
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
            @error('daily_interest_rate') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_enabled" id="is_enabled" value="1" {{ old('is_enabled',
                $settings->is_enabled) ? 'checked' : '' }}
            class="rounded border-gray-300 dark:border-gray-600 text-black dark:text-white focus:ring-black
            dark:focus:ring-white">
            <label for="is_enabled" class="text-sm text-gray-700 dark:text-gray-300">Enable Loans</label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection