<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $query = Deposit::with(['user', 'paymentMethod'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $deposits = $query->paginate(20);

        return view('admin.deposits.index', compact('deposits'));
    }

    public function show(Deposit $deposit)
    {
        $deposit->load(['user', 'paymentMethod']);
        return view('admin.deposits.show', compact('deposit'));
    }

    public function approve(Request $request, Deposit $deposit)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $deposit->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note,
        ]);

        // Add the deposit amount to user's balance
        $deposit->user->increment('balance', $deposit->amount);

        return redirect()->route('admin.deposits.index')
            ->with('success', 'Deposit approved and user balance updated.');
    }

    public function reject(Request $request, Deposit $deposit)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $deposit->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.deposits.index')
            ->with('success', 'Deposit rejected.');
    }
}
