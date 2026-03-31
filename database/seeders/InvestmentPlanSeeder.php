<?php

namespace Database\Seeders;

use App\Models\InvestmentPlan;
use Illuminate\Database\Seeder;

class InvestmentPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            ['name' => 'Basic', 'description' => 'Get 3% on this investment', 'amount' => 10000, 'roi_percentage' => 3.00, 'duration_days' => 1],
            ['name' => 'Pro', 'description' => 'Get 6.5% on this investment', 'amount' => 20000, 'roi_percentage' => 6.50, 'duration_days' => 3],
            ['name' => 'Premium', 'description' => 'Get 8% on this investment', 'amount' => 40000, 'roi_percentage' => 8.00, 'duration_days' => 6],
            ['name' => 'Master Premium', 'description' => 'Get 15% on this investment', 'amount' => 70000, 'roi_percentage' => 15.00, 'duration_days' => 12],
            ['name' => 'Crypto Pro', 'description' => 'Get 17.5% on this investment', 'amount' => 150000, 'roi_percentage' => 17.50, 'duration_days' => 14],
            ['name' => 'Crypto Premium', 'description' => 'Get 19.7% on this investment', 'amount' => 220000, 'roi_percentage' => 19.70, 'duration_days' => 17],
        ];

        foreach ($plans as $plan) {
            InvestmentPlan::firstOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
