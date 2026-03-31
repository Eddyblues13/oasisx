@extends('layouts.admin')

@section('title', 'Edit Trading Bot - ' . config('app.name'))
@section('page-title', 'Edit Trading Bot')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <div class="flex items-center gap-3">
            @if($tradingBot->image)
            <img src="{{ $tradingBot->image }}" alt="" class="w-10 h-10 rounded-lg object-cover">
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Trading Bot</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $tradingBot->name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.trading-bots.update', $tradingBot) }}" method="POST" enctype="multipart/form-data"
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bot Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $tradingBot->name) }}" required
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea name="description" id="description" rows="3"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">{{ old('description', $tradingBot->description) }}</textarea>
            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bot Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-black file:text-white dark:file:bg-white dark:file:text-black hover:file:opacity-90">
            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image.</p>
            @error('image') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="runtime_hours"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Runtime (Hours)</label>
                <input type="number" name="runtime_hours" id="runtime_hours"
                    value="{{ old('runtime_hours', $tradingBot->runtime_hours) }}" min="1" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
                @error('runtime_hours') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="hourly_roi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hourly
                    ROI (%)</label>
                <input type="number" name="hourly_roi" id="hourly_roi"
                    value="{{ old('hourly_roi', $tradingBot->hourly_roi) }}" step="0.01" min="0.01" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
                @error('hourly_roi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="min_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min
                    Stake ($)</label>
                <input type="number" name="min_amount" id="min_amount"
                    value="{{ old('min_amount', $tradingBot->min_amount) }}" step="0.01" min="0.01" required
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
                @error('min_amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="max_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max
                    Stake ($)</label>
                <input type="number" name="max_amount" id="max_amount"
                    value="{{ old('max_amount', $tradingBot->max_amount) }}" step="0.01"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
                @error('max_amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="max_concurrent" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max
                Concurrent Bots Per User</label>
            <input type="number" name="max_concurrent" id="max_concurrent"
                value="{{ old('max_concurrent', $tradingBot->max_concurrent) }}" min="1" max="10" required
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm">
            @error('max_concurrent') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $tradingBot->is_active)
            ? 'checked' : '' }}
            class="rounded border-gray-300 dark:border-gray-600 text-black dark:text-white focus:ring-black
            dark:focus:ring-white">
            <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Active</label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit"
                class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity">
                Update Bot
            </button>
            <a href="{{ route('admin.trading-bots.index') }}"
                class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection