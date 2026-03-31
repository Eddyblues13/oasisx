@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white dark:bg-black py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Reset Password
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Enter your email to receive a password reset link
            </p>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-800">
            {{-- Session Status --}}
            @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
            @endif

            <form class="space-y-6" action="{{ url('/forgot-password') }}" method="POST">
                @csrf

                <div>
                    <label for="email-address"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email address</label>
                    <input id="email-address" name="email" type="email" autocomplete="email" required
                        value="{{ old('email') }}"
                        class="appearance-none block w-full px-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white sm:text-sm dark:bg-gray-800 dark:text-white transition-colors"
                        placeholder="you@example.com">
                    @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-black hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-lg">
                        Send Reset Link
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Remember your password?
                    <a href="{{ url('/login') }}" class="font-bold text-gray-900 dark:text-white hover:underline">Sign
                        In</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection