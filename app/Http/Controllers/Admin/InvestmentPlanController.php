<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;

class InvestmentPlanController extends Controller
{
    public function index()
    {
        $plans = InvestmentPlan::latest()->get();
        return view('admin.investment-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.investment-plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:1',
            'roi_percentage' => 'required|numeric|min:0.01|max:100',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        InvestmentPlan::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'roi_percentage' => $request->roi_percentage,
            'duration_days' => $request->duration_days,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.investment-plans.index')
            ->with('success', 'Investment plan created successfully.');
    }

    public function edit(InvestmentPlan $investmentPlan)
    {
        return view('admin.investment-plans.edit', compact('investmentPlan'));
    }

    public function update(Request $request, InvestmentPlan $investmentPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:1',
            'roi_percentage' => 'required|numeric|min:0.01|max:100',
            'duration_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $investmentPlan->update([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'roi_percentage' => $request->roi_percentage,
            'duration_days' => $request->duration_days,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.investment-plans.index')
            ->with('success', 'Investment plan updated successfully.');
    }

    public function destroy(InvestmentPlan $investmentPlan)
    {
        $investmentPlan->delete();
        return redirect()->route('admin.investment-plans.index')
            ->with('success', 'Investment plan deleted successfully.');
    }
}
