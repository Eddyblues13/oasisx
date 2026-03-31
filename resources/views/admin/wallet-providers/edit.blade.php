@extends('layouts.admin')

@section('title', 'Edit Wallet Provider - ' . config('app.name'))
@section('page-title', 'Edit Wallet Provider')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.wallet-providers.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Wallet Providers
        </a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Edit: {{ $walletProvider->name }}</h2>
        </div>
        <form action="{{ route('admin.wallet-providers.update', $walletProvider) }}" method="POST"
            class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provider Name</label>
                <input type="text" name="name" value="{{ old('name', $walletProvider->name) }}" required
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" id="is_active" {{ $walletProvider->is_active ?
                'checked' : '' }}
                class="w-4 h-4 text-black dark:text-white border-gray-300 dark:border-gray-600 rounded focus:ring-black
                dark:focus:ring-white">
                <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Active</label>
            </div>
            <div class="pt-2">
                <button type="submit"
                    class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                    Update Provider
                </button>
            </div>
        </form>
    </div>
</div>
@endsection