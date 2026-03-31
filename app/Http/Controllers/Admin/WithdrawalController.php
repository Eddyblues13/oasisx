<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load('user');
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $withdrawal->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Withdrawal approved successfully.');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        // Refund the held balance back to user
        $withdrawal->user->increment('balance', $withdrawal->amount);

        $withdrawal->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.withdrawals.index')
            ->with('success', 'Withdrawal rejected and balance refunded to user.');
    }
}
