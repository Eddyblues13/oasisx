<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BotSession;
use App\Models\TradingBot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BotTradingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bots = TradingBot::active()->latest()->get();
        $runningSessions = BotSession::where('user_id', $user->id)
            ->running()
            ->with('tradingBot')
            ->latest()
            ->get();

        $maxBots = 2;

        return view('user.bot-trading', compact('bots', 'runningSessions', 'maxBots'));
    }

    public function start(Request $request, TradingBot $tradingBot)
    {
        $user = Auth::user();

        if (!$tradingBot->is_active) {
            return back()->with('error', 'This bot is no longer available.');
        }

        $rules = [
            'amount' => [
                'required',
                'numeric',
                'min:' . $tradingBot->min_amount,
            ],
        ];

        if ($tradingBot->max_amount) {
            $rules['amount'][] = 'max:' . $tradingBot->max_amount;
        }

        $request->validate($rules);

        // Check if already running this bot
        $existing = BotSession::where('user_id', $user->id)
            ->where('trading_bot_id', $tradingBot->id)
            ->where('status', 'running')
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have this bot running.');
        }

        // Check max concurrent bots limit
        $runningCount = BotSession::where('user_id', $user->id)->running()->count();
        if ($runningCount >= $tradingBot->max_concurrent) {
            return back()->with('error', 'You have reached the maximum number of running bots (' . $tradingBot->max_concurrent . ').');
        }

        // Check balance
        if ($request->amount > $user->balance) {
            return back()->with('error', 'Insufficient balance. You need $' . number_format($request->amount, 2) . ' but only have $' . number_format($user->balance, 2) . '.');
        }

        // Deduct balance
        $user->decrement('balance', $request->amount);

        BotSession::create([
            'user_id' => $user->id,
            'trading_bot_id' => $tradingBot->id,
            'amount' => $request->amount,
            'status' => 'running',
            'started_at' => now(),
        ]);

        return back()->with('success', 'Bot "' . $tradingBot->name . '" started with $' . number_format($request->amount, 2) . ' staked.');
    }

    public function stop(BotSession $botSession)
    {
        $user = Auth::user();

        if ($botSession->user_id !== $user->id) {
            abort(403);
        }

        if ($botSession->status !== 'running') {
            return back()->with('error', 'This bot session is not running.');
        }

        $botSession->update([
            'status' => 'stopped',
            'completed_at' => now(),
        ]);

        // Refund staked amount
        $user->increment('balance', $botSession->amount);

        return back()->with('success', 'Bot stopped. $' . number_format($botSession->amount, 2) . ' has been refunded to your balance.');
    }
}
