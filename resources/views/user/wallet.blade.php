@extends('layouts.user')

@section('title', 'Wallet - ' . config('app.name'))

@section('content')
<div class="space-y-6 pb-20 sm:pb-0">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Wallet</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Manage your funds and view transaction history.</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 border border-gray-100 dark:border-gray-700 flex items-center gap-3">
            <div class="p-2 bg-black dark:bg-white rounded-full text-white dark:text-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wide">Available
                    Balance</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white leading-none">${{
                    number_format(Auth::user()->balance, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Deposit Form --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-black dark:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Deposit Funds</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('wallet.deposit') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4" x-data="depositForm()">
                    @csrf
                    <div>
                        <label for="d_amount"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount ($)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="d_amount" step="0.01"
                                class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full pl-10 sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-3"
                                placeholder="Min: $100" required>
                        </div>
                        @error('amount')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="d_payment_method"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment
                            Method</label>
                        <select name="payment_method_id" id="d_payment_method" required
                            @change="handleMethodChange($event)"
                            class="block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-3 focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                            <option value="">Select a payment method</option>
                            @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" data-type="{{ $method->type }}"
                                data-wallet="{{ $method->wallet_address }}" data-network="{{ $method->network }}"
                                data-bank="{{ $method->bank_name }}" data-accnum="{{ $method->account_number }}"
                                data-accname="{{ $method->account_name }}"
                                data-instructions="{{ $method->instructions }}">
                                {{ $method->code }} - {{ $method->name }}
                            </option>
                            @endforeach
                        </select>
                        @if($paymentMethods->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No payment methods
                            available. Please contact support.</p>
                        @endif
                        @error('payment_method_id')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Payment Details (shown when method selected) --}}
                    <div x-show="selectedMethodId" x-cloak
                        class="bg-gray-50 dark:bg-gray-900 border border-dashed border-gray-300 dark:border-gray-700 rounded-lg p-4 space-y-2">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Payment Details</p>

                        {{-- Crypto details --}}
                        <template x-if="methodType === 'crypto'">
                            <div class="space-y-2">
                                <div x-show="walletAddress" class="flex items-start gap-2">
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400 shrink-0 mt-0.5">Address:</span>
                                    <span class="text-xs text-gray-900 dark:text-white font-mono break-all"
                                        x-text="walletAddress"></span>
                                </div>
                                <div x-show="network" class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Network:</span>
                                    <span class="text-xs text-gray-900 dark:text-white font-semibold"
                                        x-text="network"></span>
                                </div>
                            </div>
                        </template>

                        {{-- Bank details --}}
                        <template x-if="methodType === 'bank'">
                            <div class="space-y-1">
                                <div x-show="bankName" class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Bank:</span>
                                    <span class="text-xs text-gray-900 dark:text-white font-semibold"
                                        x-text="bankName"></span>
                                </div>
                                <div x-show="accNumber" class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Account No:</span>
                                    <span class="text-xs text-gray-900 dark:text-white font-semibold"
                                        x-text="accNumber"></span>
                                </div>
                                <div x-show="accName" class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Account Name:</span>
                                    <span class="text-xs text-gray-900 dark:text-white font-semibold"
                                        x-text="accName"></span>
                                </div>
                            </div>
                        </template>

                        <div x-show="instructions" class="pt-2 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-600 dark:text-gray-300 whitespace-pre-line"
                                x-text="instructions"></p>
                        </div>
                    </div>

                    {{-- Proof Upload --}}
                    <div x-show="selectedMethodId" x-cloak>
                        <label for="proof"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload
                            Payment Proof</label>
                        <input type="file" name="proof" id="proof" accept="image/jpeg,image/png,image/jpg" required
                            class="block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 dark:file:bg-gray-600 file:text-gray-700 dark:file:text-gray-200 hover:file:bg-gray-200 dark:hover:file:bg-gray-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Upload a screenshot of your payment.
                            Max 2MB, JPEG/PNG only.</p>
                        @error('proof')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" x-show="selectedMethodId" x-cloak
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Submit Deposit Request
                    </button>
                </form>
            </div>
        </div>

        {{-- Withdraw Form --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-black dark:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Withdraw Funds</h3>
            </div>
            <div class="p-6">
                <form x-ref="withdrawForm" action="{{ route('wallet.withdraw') }}" method="POST" class="space-y-4"
                    x-data="withdrawalForm()">
                    @csrf
                    <div>
                        <label for="w_amount"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount ($)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" name="amount" id="w_amount" x-model="amount" required
                                class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full pl-10 sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-3"
                                placeholder="Min: $100">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Available: ${{
                            number_format(Auth::user()->balance, 2) }}</p>
                        @error('amount')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="w_method"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Withdrawal
                            Method</label>
                        <select name="method" id="w_method" x-model="selectedMethod" required
                            class="block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white py-3 focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white">
                            <option value="">Select a withdrawal method</option>
                            @foreach($paymentMethods as $method)
                            <option value="{{ $method->code }}">{{ $method->code }} - {{ $method->name }}</option>
                            @endforeach
                        </select>
                        @error('method')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="selectedMethod" x-cloak>
                        <label for="w_details"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Your Wallet Address
                            / Account Details</label>
                        <textarea name="details" id="w_details" rows="3" x-model="details" required
                            class="focus:ring-black focus:border-black dark:focus:ring-white dark:focus:border-white block w-full sm:text-sm border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            placeholder="Enter your wallet address or bank details where you want to receive the funds"></textarea>
                    </div>

                    <button type="button" x-show="selectedMethod" x-cloak @click="openConfirm = true"
                        class="w-full flex justify-center py-3 px-4 border-2 border-black dark:border-white rounded-lg shadow-sm text-sm font-bold text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Request Withdrawal
                    </button>

                    {{-- Withdrawal Confirmation Modal --}}
                    <div x-show="openConfirm" x-cloak
                        class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60">
                        <div
                            class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-sm w-full mx-4 border border-gray-100 dark:border-gray-800">
                            <div
                                class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Confirm Withdrawal</h3>
                                <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    @click="openConfirm = false">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="px-5 py-4 space-y-2 text-sm">
                                <p class="text-gray-700 dark:text-gray-200">
                                    You are about to withdraw
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        $<span x-text="Number(amount || 0).toFixed(2)"></span>
                                    </span>
                                    from your wallet.
                                </p>
                                <ul class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                    <li>
                                        Method:
                                        <span class="font-semibold text-gray-900 dark:text-white"
                                            x-text="selectedMethod || 'Not selected'"></span>
                                    </li>
                                </ul>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Your balance will be deducted immediately. If rejected, the amount will be refunded.
                                </p>
                            </div>
                            <div
                                class="px-5 py-3 border-t border-gray-100 dark:border-gray-800 flex justify-end space-x-3">
                                <button type="button"
                                    class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800"
                                    @click="openConfirm = false">
                                    Cancel
                                </button>
                                <button type="button"
                                    class="px-4 py-1.5 text-xs font-semibold rounded-lg bg-black text-white dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200"
                                    @click="$refs.withdrawForm.submit()">
                                    Confirm Withdrawal
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Transaction History --}}
    <div
        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Transaction History</h3>
            <div class="p-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-500 dark:text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Date</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Type</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Amount</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Method</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $transaction['date']->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction['type'] === 'deposit')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                Deposit
                            </span>
                            @elseif($transaction['type'] === 'withdrawal')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                Withdrawal
                            </span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                Investment
                            </span>
                            @endif
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $transaction['type'] === 'deposit' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $transaction['type'] === 'deposit' ? '+' : '-' }}${{
                            number_format($transaction['amount'], 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $transaction['method'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction['status'] === 'pending')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">Pending</span>
                            @elseif($transaction['status'] === 'approved' || $transaction['status'] === 'completed')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">{{
                                ucfirst($transaction['status']) }}</span>
                            @elseif($transaction['status'] === 'active')
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">Active</span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">{{
                                ucfirst($transaction['status']) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">No transactions yet.</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Make your first deposit to get
                                    started.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('depositForm', () => ({
            selectedMethodId: null,
            methodType: '',
            walletAddress: '',
            network: '',
            bankName: '',
            accNumber: '',
            accName: '',
            instructions: '',

            handleMethodChange(event) {
                const option = event.target.selectedOptions[0];
                if (!option || !option.value) {
                    this.selectedMethodId = null;
                    this.methodType = '';
                    return;
                }
                this.selectedMethodId = option.value;
                this.methodType = option.dataset.type || '';
                this.walletAddress = option.dataset.wallet || '';
                this.network = option.dataset.network || '';
                this.bankName = option.dataset.bank || '';
                this.accNumber = option.dataset.accnum || '';
                this.accName = option.dataset.accname || '';
                this.instructions = option.dataset.instructions || '';
            }
        }));
    });

    function withdrawalForm() {
        return {
            selectedMethod: '',
            amount: '',
            details: '',
            openConfirm: false,
        }
    }
</script>
@endpush