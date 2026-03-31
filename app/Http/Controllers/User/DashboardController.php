<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $walletBalance = $user->balance ?? 0;

        $activeInvestments = $user->investments()->where('status', 'active')->get();
        $activeInvestmentsAmount = $activeInvestments->sum('amount');
        $activeInvestmentsCount = $activeInvestments->count();

        $openLoansCount = $user->loans()->whereIn('status', ['pending', 'approved'])->count();

        $activeCopyTrades = $user->copyTrades()->where('status', 'active')->get();
        $copyTradeAmount = $activeCopyTrades->sum('amount');

        $runningBots = $user->botSessions()->where('status', 'running')->get();
        $botTradingAmount = $runningBots->sum('amount');
        $runningBotsCount = $runningBots->count();

        $cryptoPortfolio = $copyTradeAmount + $botTradingAmount;

        $totalBalance = $walletBalance + $activeInvestmentsAmount + $cryptoPortfolio;

        // Recent activity: last 10 transactions across deposits, withdrawals, investments
        $recentDeposits = $user->deposits()->latest()->take(10)->get()->map(function ($d) {
            return (object) [
                'type' => 'Deposit',
                'amount' => $d->amount,
                'status' => $d->status,
                'date' => $d->created_at,
                'icon' => 'deposit',
            ];
        });

        $recentWithdrawals = $user->withdrawals()->latest()->take(10)->get()->map(function ($w) {
            return (object) [
                'type' => 'Withdrawal',
                'amount' => $w->amount,
                'status' => $w->status,
                'date' => $w->created_at,
                'icon' => 'withdrawal',
            ];
        });

        $recentInvestments = $user->investments()->latest()->take(10)->get()->map(function ($i) {
            return (object) [
                'type' => 'Investment',
                'amount' => $i->amount,
                'status' => $i->status,
                'date' => $i->created_at,
                'icon' => 'investment',
            ];
        });

        $recentActivity = $recentDeposits
            ->merge($recentWithdrawals)
            ->merge($recentInvestments)
            ->sortByDesc('date')
            ->take(10);

        return view('user.dashboard', compact(
            'walletBalance',
            'activeInvestmentsAmount',
            'activeInvestmentsCount',
            'openLoansCount',
            'cryptoPortfolio',
            'runningBotsCount',
            'totalBalance',
            'recentActivity',
        ));
    }
}
