@extends('layouts.admin')

@section('title', 'Create Admin - ' . config('app.name'))
@section('page-title', 'Create Admin')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.admins.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Admins
        </a>
    </div>

    <div class="max-w-2xl">
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Create New Admin</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                            Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password" id="password" required
                                class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm pr-10">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm
                            Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                id="password_confirmation" required
                                class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm pr-10">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <a href="{{ route('admin.admins.index') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Cancel</a>
                        <button type="submit"
                            class="py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-black hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Create Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection