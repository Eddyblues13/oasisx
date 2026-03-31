<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = LoanSetting::current();
        $loans = Loan::where('user_id', $user->id)->latest()->get();
        $openLoansCount = Loan::where('user_id', $user->id)->open()->count();
        $maxBorrowable = $user->balance * ($settings->max_ltv / 100);
        $canApply = $settings->is_enabled && $openLoansCount < $settings->max_open_loans;

        return view('user.loans', compact('settings', 'loans', 'openLoansCount', 'maxBorrowable', 'canApply'));
    }

    public function apply(Request $request)
    {
        $user = Auth::user();
        $settings = LoanSetting::current();

        if (!$settings->is_enabled) {
            return back()->with('error', 'Loans are currently disabled.');
        }

        $openLoansCount = Loan::where('user_id', $user->id)->open()->count();
        if ($openLoansCount >= $settings->max_open_loans) {
            return back()->with('error', 'You have reached the maximum number of open loans (' . $settings->max_open_loans . ').');
        }

        $maxBorrowable = $user->balance * ($settings->max_ltv / 100);

        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $maxBorrowable,
        ]);

        Loan::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Loan request for $' . number_format($request->amount, 2) . ' submitted successfully.');
    }
}
