<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Bitcoin',
                'code' => 'BTC',
                'type' => 'crypto',
                'wallet_address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh',
                'network' => 'Bitcoin',
                'instructions' => "Send the exact amount in BTC to the wallet address above.\nEnsure you use the correct network.\nPayment will be confirmed after 2 network confirmations.",
                'is_active' => true,
            ],
            [
                'name' => 'Ethereum',
                'code' => 'ETH',
                'type' => 'crypto',
                'wallet_address' => '0x71C7656EC7ab88b098defB751B7401B5f6d8976F',
                'network' => 'ERC-20',
                'instructions' => "Send ETH to the wallet address above using the ERC-20 network.\nDo not send tokens other than ETH to this address.",
                'is_active' => true,
            ],
            [
                'name' => 'Tether',
                'code' => 'USDT',
                'type' => 'crypto',
                'wallet_address' => 'TN2x5mKzHqFDBGR5mJmVhKPnGE46rqZaoM',
                'network' => 'TRC-20',
                'instructions' => "Send USDT to the wallet address above.\nMake sure you select the TRC-20 network.\nMinimum deposit: \$100.",
                'is_active' => true,
            ],
            [
                'name' => 'Litecoin',
                'code' => 'LTC',
                'type' => 'crypto',
                'wallet_address' => 'ltc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4',
                'network' => 'Litecoin',
                'instructions' => "Send LTC to the wallet address above.\nPayment is confirmed after 6 network confirmations.",
                'is_active' => true,
            ],
            [
                'name' => 'Bank Transfer',
                'code' => 'BANK',
                'type' => 'bank',
                'bank_name' => 'First National Bank',
                'account_number' => '0123456789',
                'account_name' => 'OasisX Holdings Ltd',
                'instructions' => "Transfer the exact amount to the bank account above.\nUse your registered email as the payment reference.\nBank transfers may take 1-3 business days to process.",
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['code' => $method['code']],
                $method
            );
        }
    }
}
