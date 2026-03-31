@extends('layouts.user')

@section('title', 'Wallet Connect - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="walletConnect()" data-has-approved="{{ $hasApproved ? '1' : '0' }}"
    data-daily-reward="{{ $dailyReward }}">
    {{-- Hero Banner --}}
    <div
        class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-700 rounded-2xl p-6 sm:p-8 text-white">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="100" r="80" fill="white" />
                <circle cx="350" cy="50" r="60" fill="white" />
                <circle cx="300" cy="180" r="40" fill="white" />
            </svg>
        </div>
        <div class="relative">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                <h1 class="text-2xl font-bold">Wallet Connect</h1>
            </div>
            <p class="text-purple-100 text-sm mb-4">Connect your crypto wallet and earn daily rewards.</p>

            @if($hasApproved)
            <div class="flex items-center gap-3 bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3">
                <div class="w-10 h-10 bg-green-400/20 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white/90">Current daily reward</p>
                    <p class="text-xl font-bold">${{ number_format($dailyReward, 2) }} <span
                            class="text-sm font-normal text-purple-200">/ day</span></p>
                </div>
            </div>
            @else
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                <div class="w-10 h-10 bg-yellow-400/20 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-white/90">{{ $pendingCount > 0 ? $pendingCount . ' wallet(s)
                        pending approval' : 'No wallets connected yet' }}</p>
                    <p class="text-xs text-purple-200">Connect a wallet below to start earning</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Add Wallet Form --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Wallet Address
            </h2>
        </div>
        <form action="{{ route('wallet-connect.store') }}" method="POST" class="p-5 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Wallet
                        Provider</label>
                    <select name="provider" required
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select Provider</option>
                        @foreach($providers as $provider)
                        <option value="{{ $provider->name }}" {{ old('provider')===$provider->name ? 'selected' : ''
                            }}>{{ $provider->name }}</option>
                        @endforeach
                    </select>
                    @error('provider')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Network <span
                            class="text-gray-400">(optional)</span></label>
                    <input type="text" name="network" value="{{ old('network') }}"
                        placeholder="e.g. ERC-20, BEP-20, TRC-20"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-purple-500 focus:border-purple-500">
                    @error('network')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Wallet Address</label>
                <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter your wallet address"
                    required
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-purple-500 focus:border-purple-500 font-mono">
                @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Label <span
                        class="text-gray-400">(optional)</span></label>
                <input type="text" name="label" value="{{ old('label') }}" placeholder="e.g. My Main Wallet"
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 dark:text-white focus:ring-purple-500 focus:border-purple-500">
                @error('label')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full sm:w-auto px-6 py-2.5 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                Connect Wallet
            </button>
        </form>
    </div>

    {{-- Security Reminder --}}
    <div
        class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 flex gap-3">
        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
            </path>
        </svg>
        <div>
            <p class="text-sm font-medium text-amber-800 dark:text-amber-300">Security Reminder</p>
            <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">Never share your private keys or seed phrases. We
                only need your public wallet address. Your wallet will be verified by our team before rewards are
                activated.</p>
        </div>
    </div>

    {{-- Connected Wallets --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Connected Wallets</h2>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $connections->count() }} {{ Str::plural('wallet',
                $connections->count()) }}</span>
        </div>

        @forelse($connections as $connection)
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $connection->provider }}</p>
                        @if($connection->network)
                        <span
                            class="text-xs px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded">{{
                            $connection->network }}</span>
                        @endif

                        @if($connection->status === 'approved')
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Connected
                        </span>
                        @elseif($connection->status === 'pending')
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Waiting for approval
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Rejected
                        </span>
                        @endif
                    </div>

                    @if($connection->label)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $connection->label }}</p>
                    @endif

                    <p class="text-xs text-gray-600 dark:text-gray-300 font-mono break-all">{{ $connection->address }}
                    </p>

                    @if($connection->status === 'approved' && $connection->daily_reward > 0)
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1 font-medium">
                        Earning ${{ number_format($connection->daily_reward, 2) }}/day
                    </p>
                    @endif

                    @if($connection->admin_note && $connection->status === 'rejected')
                    <p class="text-xs text-red-500 mt-1">Note: {{ $connection->admin_note }}</p>
                    @endif
                </div>

                <button @click="confirmDelete({{ $connection->id }})"
                    class="shrink-0 p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        @empty
        <div class="p-8 text-center">
            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            <p class="text-sm text-gray-500 dark:text-gray-400">No wallets connected yet.</p>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Add a wallet above to get started.</p>
        </div>
        @endforelse
    </div>

    {{-- Delete Confirmation Modal --}}
    <div x-show="showDeleteModal" x-cloak x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div @click.away="showDeleteModal = false" x-transition
            class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-sm w-full p-6">
            <div class="text-center">
                <div
                    class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Remove Wallet</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Are you sure you want to remove this wallet?
                    This action cannot be undone.</p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                        class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </button>
                    <form :action="deleteUrl" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            Remove
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Approval Notification Overlay --}}
    <template x-if="showApprovalNotice">
        <div x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-sm w-full p-6 text-center">
                <div
                    class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Wallet Approved!</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Your wallet has been approved and is now
                    earning rewards.</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400 mb-6">${{ number_format($dailyReward, 2)
                    }}/day</p>
                <button @click="dismissApproval()"
                    class="w-full px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                    Awesome!
                </button>
            </div>
        </div>
    </template>
</div>

<script>
    function walletConnect() {
    return {
        showDeleteModal: false,
        deleteUrl: '',
        showApprovalNotice: false,
        init() {
            const el = this.$el;
            const hasApproved = el.dataset.hasApproved === '1';
            const dailyReward = parseFloat(el.dataset.dailyReward) || 0;
            const storageKey = 'wallet_approved_' + dailyReward;

            if (hasApproved && dailyReward > 0 && !localStorage.getItem(storageKey)) {
                this.showApprovalNotice = true;
            }
        },
        confirmDelete(id) {
            this.deleteUrl = '{{ url("wallet-connect") }}/' + id;
            this.showDeleteModal = true;
        },
        dismissApproval() {
            const el = this.$el;
            const dailyReward = parseFloat(el.dataset.dailyReward) || 0;
            localStorage.setItem('wallet_approved_' + dailyReward, '1');
            this.showApprovalNotice = false;
        }
    }
}
</script>
@endsection