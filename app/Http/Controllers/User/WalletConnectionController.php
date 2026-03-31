<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WalletConnection;
use App\Models\WalletProvider;
use Illuminate\Http\Request;

class WalletConnectionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $providers = WalletProvider::active()->orderBy('name')->get();
        $connections = $user->walletConnections()->latest()->get();
        $hasApproved = $connections->where('status', 'approved')->isNotEmpty();
        $pendingCount = $connections->where('status', 'pending')->count();
        $dailyReward = $connections->where('status', 'approved')->sum('daily_reward');

        return view('user.wallet-connect', compact(
            'providers',
            'connections',
            'hasApproved',
            'pendingCount',
            'dailyReward'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string|max:100',
            'network' => 'nullable|string|max:100',
            'address' => 'required|string|max:500',
            'label' => 'nullable|string|max:100',
        ]);

        auth()->user()->walletConnections()->create([
            'provider' => $request->provider,
            'network' => $request->network,
            'address' => $request->address,
            'label' => $request->label,
        ]);

        return back()->with('success', 'Wallet submitted for approval.');
    }

    public function destroy(WalletConnection $walletConnection)
    {
        if ($walletConnection->user_id !== auth()->id()) {
            abort(403);
        }

        $walletConnection->delete();

        return back()->with('success', 'Wallet connection removed.');
    }
}
