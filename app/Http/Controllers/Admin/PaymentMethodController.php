<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->get();
        return view('admin.payment-methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:payment_methods,code',
            'type' => 'required|in:crypto,bank',
            'wallet_address' => 'nullable|string|max:500',
            'network' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        PaymentMethod::create($request->only([
            'name',
            'code',
            'type',
            'wallet_address',
            'network',
            'bank_name',
            'account_number',
            'account_name',
            'instructions',
            'is_active',
        ]));

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:payment_methods,code,' . $paymentMethod->id,
            'type' => 'required|in:crypto,bank',
            'wallet_address' => 'nullable|string|max:500',
            'network' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
            'instructions' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $paymentMethod->update($request->only([
            'name',
            'code',
            'type',
            'wallet_address',
            'network',
            'bank_name',
            'account_number',
            'account_name',
            'instructions',
            'is_active',
        ]));

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
