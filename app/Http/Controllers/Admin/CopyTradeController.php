<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CopyTrade;
use Illuminate\Http\Request;

class CopyTradeController extends Controller
{
    public function index(Request $request)
    {
        $query = CopyTrade::with(['user', 'trader'])->latest();

        if ($request->filled('status') && in_array($request->status, ['active', 'stopped'])) {
            $query->where('status', $request->status);
        }

        $copyTrades = $query->paginate(20)->withQueryString();

        return view('admin.copy-trades.index', compact('copyTrades'));
    }
}
