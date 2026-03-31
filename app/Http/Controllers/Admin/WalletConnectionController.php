<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletConnection;
use Illuminate\Http\Request;

class WalletConnectionController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletConnection::with('user')->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $connections = $query->paginate(20)->withQueryString();

        return view('admin.wallet-connections.index', compact('connections'));
    }

    public function show(WalletConnection $walletConnection)
    {
        $walletConnection->load('user');

        return view('admin.wallet-connections.show', compact('walletConnection'));
    }

    public function approve(Request $request, WalletConnection $walletConnection)
    {
        $request->validate([
            'daily_reward' => 'required|numeric|min:0',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $walletConnection->update([
            'status' => 'approved',
            'daily_reward' => $request->daily_reward,
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Wallet approved with $' . number_format($request->daily_reward, 2) . '/day reward.');
    }

    public function reject(Request $request, WalletConnection $walletConnection)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $walletConnection->update([
            'status' => 'rejected',
            'daily_reward' => 0,
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Wallet connection rejected.');
    }

    public function destroy(WalletConnection $walletConnection)
    {
        $walletConnection->delete();

        return redirect()->route('admin.wallet-connections.index')->with('success', 'Wallet connection deleted.');
    }
}
