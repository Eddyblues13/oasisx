@extends('layouts.user')

@section('title', 'Profile - ' . config('app.name'))

@section('content')
<div class="space-y-6 pb-20 sm:pb-0">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Manage your account information and preferences.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Card --}}
        <div class="lg:col-span-1">
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden text-center p-6">
                <div class="relative inline-block mb-4">
                    @if($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                        class="h-32 w-32 rounded-full object-cover mx-auto border-4 border-white dark:border-gray-700 shadow-lg">
                    @else
                    <div
                        class="h-32 w-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mx-auto border-4 border-white dark:border-gray-700 shadow-lg">
                        <span class="text-4xl font-bold text-gray-500 dark:text-gray-400">{{
                            strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    @endif
                    <div class="absolute bottom-1 right-1 bg-green-500 w-5 h-5 rounded-full border-2 border-white dark:border-gray-800"
                        title="Online"></div>
                </div>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">{{ $user->email }}</p>
                @if($user->phone)
                <p class="text-gray-500 dark:text-gray-400 text-xs mb-4">{{ $user->phone }}</p>
                @else
                <p class="mb-4"></p>
                @endif

                <div class="flex flex-wrap justify-center gap-2 mb-6">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                        Member
                    </span>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-3">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Joined</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
                            <span
                                class="text-black dark:text-white font-medium text-sm flex items-center justify-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="lg:col-span-2">
            {{-- Referral Program --}}
            <div
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Referral Program</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Referrals</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $referralCount }}</p>
                        </div>
                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Referral Code</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white tracking-widest">{{
                                $user->referral_code }}</p>
                        </div>
                    </div>
                    <div x-data="{ copied: false }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Your Referral
                            Link</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="text" readonly value="{{ $referralLink }}" id="referral-link"
                                class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white flex-1 block w-full rounded-none rounded-l-lg sm:text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5">
                            <button type="button"
                                @click="navigator.clipboard.writeText(document.getElementById('referral-link').value); copied = true; setTimeout(() => copied = false, 2000)"
                                class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-r-lg text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:ring-1 focus:ring-black focus:border-black transition-colors">
                                <svg x-show="!copied" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3">
                                    </path>
                                </svg>
                                <svg x-show="copied" x-cloak class="h-5 w-5 text-green-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Share this link to invite friends to
                            join.</p>
                    </div>
                </div>
            </div>

            {{-- Edit Information --}}
            <div
                class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Information</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6" x-data="{ preview: null }">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile
                                Photo</label>
                            <div class="flex items-center gap-4">
                                <div class="shrink-0">
                                    <template x-if="preview">
                                        <img :src="preview"
                                            class="h-14 w-14 rounded-full object-cover border border-gray-200 dark:border-gray-600">
                                    </template>
                                    <template x-if="!preview">
                                        @if($user->avatar)
                                        <img src="{{ $user->avatar }}"
                                            class="h-14 w-14 rounded-full object-cover border border-gray-200 dark:border-gray-600">
                                        @else
                                        <div
                                            class="h-14 w-14 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                            <span class="text-lg font-bold text-gray-500 dark:text-gray-400">{{
                                                strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        @endif
                                    </template>
                                </div>
                                <label
                                    class="cursor-pointer bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-black dark:focus-within:ring-white transition-colors shadow-sm">
                                    <span>Change Photo</span>
                                    <input type="file" name="avatar" class="sr-only" accept="image/*"
                                        @change="if($event.target.files[0]) { preview = URL.createObjectURL($event.target.files[0]) }">
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">JPG, GIF or PNG. Max 2MB.</p>
                            </div>
                            @error('avatar')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm">
                                @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                                    Address</label>
                                <input type="email" id="email" value="{{ $user->email }}" disabled
                                    class="block w-full sm:text-sm border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-500 cursor-not-allowed py-2.5 shadow-sm">
                                <p class="mt-1 text-xs text-gray-500">Contact support to change email.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone
                                    Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="+1 (555) 000-0000"
                                    class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm">
                                @error('phone')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Referred
                                    By</label>
                                <input type="text"
                                    value="{{ $user->referrer ? $user->referrer->name : 'Direct Sign-up' }}" disabled
                                    class="block w-full sm:text-sm border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-500 cursor-not-allowed py-2.5 shadow-sm">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-black hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Security Section - Password Change --}}
            <div
                class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Change Password</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div x-data="{ show: false }">
                            <label for="current_password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current
                                Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="current_password" id="current_password"
                                    required
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
                            @error('current_password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div x-data="{ show: false }">
                                <label for="password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New
                                    Password</label>
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
                                @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-data="{ show: false }">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New
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
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-black hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection