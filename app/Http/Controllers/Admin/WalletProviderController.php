<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletProvider;
use Illuminate\Http\Request;

class WalletProviderController extends Controller
{
    public function index()
    {
        $providers = WalletProvider::latest()->get();

        return view('admin.wallet-providers.index', compact('providers'));
    }

    public function create()
    {
        return view('admin.wallet-providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:wallet_providers,name',
        ]);

        WalletProvider::create([
            'name' => $request->name,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.wallet-providers.index')->with('success', 'Wallet provider created.');
    }

    public function edit(WalletProvider $walletProvider)
    {
        return view('admin.wallet-providers.edit', compact('walletProvider'));
    }

    public function update(Request $request, WalletProvider $walletProvider)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:wallet_providers,name,' . $walletProvider->id,
        ]);

        $walletProvider->update([
            'name' => $request->name,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.wallet-providers.index')->with('success', 'Wallet provider updated.');
    }

    public function destroy(WalletProvider $walletProvider)
    {
        $walletProvider->delete();

        return redirect()->route('admin.wallet-providers.index')->with('success', 'Wallet provider deleted.');
    }
}
