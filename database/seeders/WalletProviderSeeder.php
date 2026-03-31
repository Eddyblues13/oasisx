<?php

namespace Database\Seeders;

use App\Models\WalletProvider;
use Illuminate\Database\Seeder;

class WalletProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            'Trust Wallet',
            'MetaMask',
            'WalletConnect',
            'Coinbase Wallet',
            'Binance',
            'Crypto.com',
            'Phantom',
            'OKX',
            'KuCoin',
            'Bitget',
            'Bybit',
            'Ledger',
            'Trezor',
            'Exodus',
        ];

        foreach ($providers as $name) {
            WalletProvider::firstOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
