@extends('layouts.admin')

@section('title', 'Edit ' . $user->name . ' - Admin')
@section('page-title', 'Edit User')

@section('content')
<div class="space-y-6">
    {{-- Back Button --}}
    <div>
        <a href="{{ route('admin.users.show', $user) }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to User
        </a>
    </div>

    <div class="max-w-2xl">
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit User: {{ $user->name }}</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm">
                        @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email
                            Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-2.5 shadow-sm">
                        @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-between">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="py-2.5 px-6 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-black hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection