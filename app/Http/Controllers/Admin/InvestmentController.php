<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Investment::with(['user', 'plan'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $investments = $query->paginate(20);

        return view('admin.investments.index', compact('investments'));
    }

    public function show(Investment $investment)
    {
        $investment->load(['user', 'plan']);
        return view('admin.investments.show', compact('investment'));
    }

    public function complete(Request $request, Investment $investment)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        // Credit expected payout to user balance
        $investment->user->increment('balance', $investment->expected_payout);

        $investment->update([
            'status' => 'completed',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.investments.index')
            ->with('success', 'Investment completed. $' . number_format($investment->expected_payout, 2) . ' credited to user.');
    }

    public function cancel(Request $request, Investment $investment)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        // Refund original investment amount back to user
        $investment->user->increment('balance', $investment->amount);

        $investment->update([
            'status' => 'cancelled',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.investments.index')
            ->with('success', 'Investment cancelled. $' . number_format($investment->amount, 2) . ' refunded to user.');
    }
}
