@extends('layouts.admin')

@section('title', $user->name . ' - Admin')
@section('page-title', 'User Details')

@section('content')
<div class="space-y-6">
    {{-- Back Button --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Users
        </a>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.users.impersonate', $user) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg border border-yellow-300 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors"
                    onclick="return confirm('Login as this user?')">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Login as User
                </button>
            </form>
            <a href="{{ route('admin.users.edit', $user) }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-black dark:bg-white text-white dark:text-black hover:opacity-90 transition-opacity">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit
            </a>
        </div>
    </div>

    {{-- Status Banner --}}
    @if($user->status === 'suspended')
    <div
        class="flex items-center gap-3 px-4 py-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl text-sm text-yellow-800 dark:text-yellow-200">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
            </path>
        </svg>
        This user account is currently <strong>suspended</strong>.
        <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="ml-auto">
            @csrf @method('PATCH')
            <button type="submit"
                class="px-3 py-1 bg-yellow-600 text-white text-xs font-medium rounded-lg hover:bg-yellow-700 transition-colors">Reactivate</button>
        </form>
    </div>
    @elseif($user->status === 'banned')
    <div
        class="flex items-center gap-3 px-4 py-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-800 dark:text-red-200">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
            </path>
        </svg>
        This user account is <strong>banned</strong>.
        <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="ml-auto">
            @csrf @method('PATCH')
            <button type="submit"
                class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-lg hover:bg-red-700 transition-colors">Unban</button>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: User Profile Card --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Profile Card --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6 text-center">
                <div
                    class="h-20 w-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4 ring-4 ring-white dark:ring-gray-800 shadow">
                    @if($user->avatar)
                    <img src="{{ $user->avatar }}" class="h-20 w-20 rounded-full object-cover" alt="">
                    @else
                    <span class="text-3xl font-bold text-gray-500 dark:text-gray-400">{{ strtoupper(substr($user->name,
                        0, 1)) }}</span>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->email }}</p>

                <div class="mt-3 flex justify-center">
                    @if($user->status === 'active')
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                    </span>
                    @elseif($user->status === 'suspended')
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Suspended
                    </span>
                    @else
                    <span
                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Banned
                    </span>
                    @endif
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700 mt-4 pt-4">
                    <dl class="grid grid-cols-2 gap-4 text-left text-sm">
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">User ID</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">#{{ $user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Joined</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y')
                                }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Verified</dt>
                            <dd class="font-medium {{ $user->email_verified_at ? 'text-green-600' : 'text-red-500' }}">
                                {{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'No' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Referral Code</dt>
                            <dd class="font-medium font-mono text-gray-900 dark:text-white text-xs">{{
                                $user->referral_code ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Phone</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $user->phone ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 uppercase tracking-wide">Referrals</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">{{ $user->referrals_count }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 uppercase tracking-wide">Activity
                    Summary</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Deposits</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $user->deposits_count }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Withdrawals</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $user->withdrawals_count }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Investments</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $user->investments_count }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Loans</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $user->loans_count }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Copy Trades</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $user->copy_trades_count }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Bot Sessions</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $user->bot_sessions_count }}</span>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-red-200 dark:border-red-900/50 p-6">
                <h3 class="text-sm font-bold text-red-600 dark:text-red-400 mb-4 uppercase tracking-wide">Danger Zone
                </h3>
                <div class="space-y-3">
                    @if($user->status === 'active')
                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-yellow-300 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors"
                            onclick="return confirm('Suspend this user?')">
                            Suspend User
                        </button>
                    </form>
                    <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium rounded-lg border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                            onclick="return confirm('Ban this user? They will no longer be able to log in.')">
                            Ban User
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                        onsubmit="return confirm('Permanently delete this user and all their data? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                            Delete User Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Financial Overview --}}
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Balance</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($user->balance,
                        2) }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Deposited</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">${{
                        number_format($stats['total_deposited'], 2) }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Withdrawn</p>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">${{
                        number_format($stats['total_withdrawn'], 2) }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Active / Open</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stats['active_investments'] +
                        $stats['open_loans'] }}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $stats['active_investments'] }} inv · {{
                        $stats['open_loans'] }} loans</p>
                </div>
            </div>

            {{-- Fund Account --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Fund / Debit Account</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Manually adjust user balance. Current:
                        <strong>${{ number_format($user->balance, 2) }}</strong>
                    </p>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.users.fund', $user) }}" method="POST"
                        class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                            <select name="type"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white">
                                <option value="credit">Credit (Add)</option>
                                <option value="debit">Debit (Subtract)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Amount
                                ($)</label>
                            <input type="number" name="amount" step="0.01" min="0.01" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"
                                placeholder="0.00">
                            @error('amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Reason
                                (optional)</label>
                            <input type="text" name="reason"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"
                                placeholder="e.g. Bonus, Correction">
                        </div>
                        <button type="submit"
                            class="px-4 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity"
                            onclick="return confirm('Confirm balance adjustment?')">
                            Apply
                        </button>
                    </form>
                </div>
            </div>

            {{-- Send Email --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Send Email</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.users.send-email', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                            <input type="text" name="subject" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"
                                placeholder="Email subject" value="{{ old('subject') }}">
                            @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                            <textarea name="message" rows="4" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"
                                placeholder="Write your message...">{{ old('message') }}</textarea>
                            @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Send Email
                        </button>
                    </form>
                </div>
            </div>

            {{-- Reset Password --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Reset Password</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.users.reset-password', $user) }}" method="POST"
                        class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div x-data="{ show: false }">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">New
                                Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="new_password" required minlength="6"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white pr-10"
                                    placeholder="Min 6 characters">
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
                            @error('new_password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div x-data="{ show: false }">
                            <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm
                                Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="new_password_confirmation" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white pr-10"
                                    placeholder="Repeat password">
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
                        <button type="submit"
                            class="px-4 py-2.5 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity"
                            onclick="return confirm('Reset this user\'s password?')">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- Admin Notes --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Admin Notes</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Internal notes about this user. Not
                        visible to the user.</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.users.update-notes', $user) }}" method="POST" class="space-y-3">
                        @csrf @method('PATCH')
                        <textarea name="admin_notes" rows="3"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white text-sm focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white"
                            placeholder="Add notes about this user...">{{ old('admin_notes', $user->admin_notes) }}</textarea>
                        <button type="submit"
                            class="px-4 py-2 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:opacity-90 transition-opacity">
                            Save Notes
                        </button>
                    </form>
                </div>
            </div>

            {{-- Recent Deposits --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Deposits</h3>
                    <a href="{{ route('admin.deposits.index', ['search' => $user->email]) }}"
                        class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">View
                        All &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Date</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Amount</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Method</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentDeposits as $deposit)
                            <tr>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{
                                    $deposit->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">${{
                                    number_format($deposit->amount, 2) }}</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{ $deposit->paymentMethod->name
                                    ?? '—' }}</td>
                                <td class="px-4 py-2">
                                    @if($deposit->status === 'approved')
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                                    @elseif($deposit->status === 'pending')
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Pending</span>
                                    @else
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400 text-xs">No deposits yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Recent Withdrawals --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Withdrawals</h3>
                    <a href="{{ route('admin.withdrawals.index', ['search' => $user->email]) }}"
                        class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">View
                        All &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Date</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Amount</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Method</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentWithdrawals as $withdrawal)
                            <tr>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{
                                    $withdrawal->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">${{
                                    number_format($withdrawal->amount, 2) }}</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{
                                    $withdrawal->paymentMethod->name ?? '—' }}</td>
                                <td class="px-4 py-2">
                                    @if($withdrawal->status === 'approved')
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Approved</span>
                                    @elseif($withdrawal->status === 'pending')
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Pending</span>
                                    @else
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-400 text-xs">No withdrawals yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection