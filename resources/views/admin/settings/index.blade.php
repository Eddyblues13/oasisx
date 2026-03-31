@extends('layouts.admin')

@section('title', 'Settings - ' . config('app.name'))
@section('page-title', 'Settings')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Account Settings</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage your admin profile and security preferences.</p>
    </div>

    {{-- Profile Information --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Profile Information</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update your name and email address.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.settings.update-profile') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth('admin')->user()->name) }}"
                            required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white">
                        @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', auth('admin')->user()->email) }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white">
                        @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Change Password --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Change Password</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Use a strong, unique password to keep your
                account secure.</p>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.settings.update-password') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div x-data="{ show: false }">
                    <label for="current_password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="current_password" id="current_password" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white pr-10">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    @error('current_password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div x-data="{ show: false }">
                        <label for="new_password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="new_password" id="new_password" required
                                minlength="6"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white pr-10">
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
                        @error('new_password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div x-data="{ show: false }">
                        <label for="new_password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New
                            Password</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" name="new_password_confirmation"
                                id="new_password_confirmation" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white pr-10">
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
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Session Info --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Session Information</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Logged in as</dt>
                    <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ auth('admin')->user()->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ auth('admin')->user()->email }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Account Created</dt>
                    <dd class="mt-1 font-medium text-gray-900 dark:text-white">
                        {{ auth('admin')->user()->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500 dark:text-gray-400">Last Updated</dt>
                    <dd class="mt-1 font-medium text-gray-900 dark:text-white">
                        {{ auth('admin')->user()->updated_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Danger Zone --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-red-200 dark:border-red-900/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 dark:border-red-900/30">
            <h3 class="text-lg font-bold text-red-600 dark:text-red-400">Danger Zone</h3>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Log out of all sessions</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sign out everywhere and require a fresh
                        login.</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 text-sm font-medium rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection