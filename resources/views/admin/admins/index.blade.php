@extends('layouts.admin')

@section('title', 'Manage Admins - ' . config('app.name'))
@section('page-title', 'Admins')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admins</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Manage administrator accounts.</p>
        </div>
        <a href="{{ route('admin.admins.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-black dark:bg-white text-white dark:text-black text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Admin
        </a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            ID</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Name</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Email</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Created</th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">#{{ $admin->id
                            }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{
                            $admin->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $admin->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{
                            $admin->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            @if($admin->id !== auth('admin')->id())
                            <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="inline"
                                onsubmit="return confirm('Delete this admin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">(You)</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No admins found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($admins->hasPages())
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
            {{ $admins->links() }}
        </div>
        @endif
    </div>
</div>
@endsection