@extends('layouts.admin')

@section('title', 'Edit Trader - ' . config('app.name'))
@section('page-title', 'Edit Trader')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.traders.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Traders
        </a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                @if($trader->avatar)
                <img src="{{ $trader->avatar }}" alt="{{ $trader->trader_name }}"
                    class="w-10 h-10 rounded-full object-cover">
                @endif
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Edit: {{ $trader->name }}</h2>
            </div>
        </div>
        <form action="{{ route('admin.traders.update', $trader) }}" method="POST" enctype="multipart/form-data"
            class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Strategy Name</label>
                <input type="text" name="name" value="{{ old('name', $trader->name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trader Name</label>
                <input type="text" name="trader_name" value="{{ old('trader_name', $trader->trader_name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                @error('trader_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description <span
                        class="text-gray-400">(optional)</span></label>
                <textarea name="description" rows="3"
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">{{ old('description', $trader->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Avatar Image <span
                        class="text-gray-400">(leave blank to keep current)</span></label>
                <input type="file" name="avatar" accept="image/*"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 dark:file:bg-gray-700 file:text-gray-700 dark:file:text-gray-300 hover:file:bg-gray-200 dark:hover:file:bg-gray-600">
                @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Daily ROI (%)</label>
                    <input type="number" name="daily_roi" value="{{ old('daily_roi', $trader->daily_roi) }}" step="0.01"
                        min="0.01" required
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                    @error('daily_roi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Risk Level</label>
                    <select name="risk_level" required
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        <option value="low" {{ old('risk_level', $trader->risk_level) === 'low' ? 'selected' : '' }}>Low
                        </option>
                        <option value="medium" {{ old('risk_level', $trader->risk_level) === 'medium' ? 'selected' : ''
                            }}>Medium</option>
                        <option value="high" {{ old('risk_level', $trader->risk_level) === 'high' ? 'selected' : ''
                            }}>High</option>
                    </select>
                    @error('risk_level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Min Amount
                        ($)</label>
                    <input type="number" name="min_amount" value="{{ old('min_amount', $trader->min_amount) }}"
                        step="0.01" min="0.01" required
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                    @error('min_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Amount ($) <span
                            class="text-gray-400">(optional)</span></label>
                    <input type="number" name="max_amount" value="{{ old('max_amount', $trader->max_amount) }}"
                        step="0.01"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                    @error('max_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ $trader->is_active ? 'checked' : ''
                }}
                class="w-4 h-4 text-black dark:text-white border-gray-300 dark:border-gray-600 rounded focus:ring-black
                dark:focus:ring-white">
                <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Active</label>
            </div>
            <div class="pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                    Update Trader
                </button>
            </div>
        </form>
    </div>
</div>
@endsection