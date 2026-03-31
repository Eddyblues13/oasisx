<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('user')->latest();

        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'repaid'])) {
            $query->where('status', $request->status);
        }

        $loans = $query->paginate(20);

        return view('admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load('user');

        return view('admin.loans.show', compact('loan'));
    }

    public function approve(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'This loan is not pending.');
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $loan->update([
            'status' => 'approved',
            'admin_note' => $request->admin_note,
            'outstanding_amount' => $loan->amount,
            'approved_at' => now(),
        ]);

        // Credit the loan amount to user's balance
        $loan->user->increment('balance', $loan->amount);

        return back()->with('success', 'Loan approved. $' . number_format($loan->amount, 2) . ' credited to user.');
    }

    public function reject(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'This loan is not pending.');
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $loan->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return back()->with('success', 'Loan rejected.');
    }

    public function markRepaid(Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Only approved loans can be marked as repaid.');
        }

        $loan->update([
            'status' => 'repaid',
            'outstanding_amount' => 0,
            'repaid_at' => now(),
        ]);

        return back()->with('success', 'Loan marked as repaid.');
    }
}
