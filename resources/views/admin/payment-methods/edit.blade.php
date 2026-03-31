@extends('layouts.admin')

@section('title', 'Edit Payment Method - ' . config('app.name'))
@section('page-title', 'Edit Payment Method')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.payment-methods.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400 hover:text-black dark:hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Payment Methods
        </a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Edit: {{ $paymentMethod->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update payment method details.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST" class="space-y-5"
                x-data="{ type: '{{ old('type', $paymentMethod->type) }}' }">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', $paymentMethod->name) }}" required
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Code</label>
                        <input type="text" name="code" value="{{ old('code', $paymentMethod->code) }}" required
                            maxlength="20"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white uppercase">
                        @error('code') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                    <select name="type" x-model="type"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        <option value="crypto">Crypto</option>
                        <option value="bank">Bank Transfer</option>
                    </select>
                    @error('type') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Crypto Fields --}}
                <div x-show="type === 'crypto'" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Wallet
                            Address</label>
                        <input type="text" name="wallet_address"
                            value="{{ old('wallet_address', $paymentMethod->wallet_address) }}"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white font-mono">
                        @error('wallet_address') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Network</label>
                        <input type="text" name="network" value="{{ old('network', $paymentMethod->network) }}"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('network') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Bank Fields --}}
                <div x-show="type === 'bank'" x-cloak class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $paymentMethod->bank_name) }}"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                        @error('bank_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account
                                Number</label>
                            <input type="text" name="account_number"
                                value="{{ old('account_number', $paymentMethod->account_number) }}"
                                class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                            @error('account_number') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account
                                Name</label>
                            <input type="text" name="account_name"
                                value="{{ old('account_name', $paymentMethod->account_name) }}"
                                class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                            @error('account_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instructions</label>
                    <textarea name="instructions" rows="3"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">{{ old('instructions', $paymentMethod->instructions) }}</textarea>
                    @error('instructions') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ $paymentMethod->is_active ?
                    'checked' : '' }}
                    class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded dark:bg-gray-700
                    dark:border-gray-600">
                    <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Active (visible to
                        users)</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.payment-methods.index') }}"
                        class="px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
                        Update Method
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection