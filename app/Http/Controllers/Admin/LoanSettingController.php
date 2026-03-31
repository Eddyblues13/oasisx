<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanSetting;
use Illuminate\Http\Request;

class LoanSettingController extends Controller
{
    public function edit()
    {
        $settings = LoanSetting::current();

        return view('admin.loan-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_open_loans' => 'required|integer|min:1|max:10',
            'max_ltv' => 'required|numeric|min:1|max:100',
            'daily_interest_rate' => 'required|numeric|min:0.01|max:100',
        ]);

        $settings = LoanSetting::current();
        $settings->update([
            'max_open_loans' => $request->max_open_loans,
            'max_ltv' => $request->max_ltv,
            'daily_interest_rate' => $request->daily_interest_rate,
            'is_enabled' => $request->boolean('is_enabled', false),
        ]);

        return back()->with('success', 'Loan settings updated successfully.');
    }
}
