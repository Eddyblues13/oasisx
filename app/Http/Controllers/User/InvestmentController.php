<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $plans = InvestmentPlan::active()->orderBy('amount')->get();
        $myInvestments = Investment::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->get();

        return view('user.investments', compact('plans', 'myInvestments'));
    }

    public function invest(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'investment_plan_id' => 'required|exists:investment_plans,id',
        ]);

        $plan = InvestmentPlan::where('id', $request->investment_plan_id)
            ->where('is_active', true)
            ->firstOrFail();

        if ($plan->amount > $user->balance) {
            return back()->withErrors(['investment_plan_id' => 'Insufficient balance. Your available balance is $' . number_format($user->balance, 2) . '. This plan requires $' . number_format($plan->amount, 2) . '.']);
        }

        // Deduct balance immediately
        $user->decrement('balance', $plan->amount);

        Investment::create([
            'user_id' => $user->id,
            'investment_plan_id' => $plan->id,
            'amount' => $plan->amount,
            'roi_percentage' => $plan->roi_percentage,
            'expected_payout' => $plan->expected_payout,
            'duration_days' => $plan->duration_days,
            'status' => 'active',
            'expires_at' => now()->addDays($plan->duration_days),
        ]);

        return back()->with('success', 'Investment of $' . number_format($plan->amount, 2) . ' in ' . $plan->name . ' plan placed successfully!');
    }
}
