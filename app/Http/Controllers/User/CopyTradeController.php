<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CopyTrade;
use App\Models\Trader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CopyTradeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $traders = Trader::active()->latest()->get();
        $activeTrades = CopyTrade::where('user_id', $user->id)
            ->active()
            ->with('trader')
            ->latest()
            ->get();

        $maxStrategies = 3;

        return view('user.copy-trade', compact('traders', 'activeTrades', 'maxStrategies'));
    }

    public function subscribe(Request $request, Trader $trader)
    {
        $user = Auth::user();

        if (!$trader->is_active) {
            return back()->with('error', 'This strategy is no longer available.');
        }

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:' . $trader->min_amount,
                $trader->max_amount ? 'max:' . $trader->max_amount : '',
            ],
        ]);

        // Check if already following this trader
        $existing = CopyTrade::where('user_id', $user->id)
            ->where('trader_id', $trader->id)
            ->where('status', 'active')
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already following this strategy.');
        }

        // Check max strategies limit
        $activeCount = CopyTrade::where('user_id', $user->id)->active()->count();
        if ($activeCount >= 3) {
            return back()->with('error', 'You have reached the maximum number of active strategies (3).');
        }

        // Check balance
        if ($request->amount > $user->balance) {
            return back()->with('error', 'Insufficient balance. You need $' . number_format($request->amount, 2) . ' but only have $' . number_format($user->balance, 2) . '.');
        }

        // Deduct balance
        $user->decrement('balance', $request->amount);

        CopyTrade::create([
            'user_id' => $user->id,
            'trader_id' => $trader->id,
            'amount' => $request->amount,
            'status' => 'active',
        ]);

        return back()->with('success', 'You are now following "' . $trader->name . '" with $' . number_format($request->amount, 2) . ' allocated.');
    }

    public function unsubscribe(CopyTrade $copyTrade)
    {
        $user = Auth::user();

        if ($copyTrade->user_id !== $user->id) {
            abort(403);
        }

        if ($copyTrade->status !== 'active') {
            return back()->with('error', 'This copy trade is already stopped.');
        }

        $copyTrade->update(['status' => 'stopped']);

        // Refund the amount back to user balance
        $user->increment('balance', $copyTrade->amount);

        return back()->with('success', 'Strategy stopped. $' . number_format($copyTrade->amount, 2) . ' returned to your wallet.');
    }
}
