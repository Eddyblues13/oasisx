<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $recentUsers = User::latest()->take(5)->get();
        $pendingDeposits = Deposit::where('status', 'pending')->count();
        $totalDeposits = Deposit::where('status', 'approved')->sum('amount');

        return view('admin.dashboard', compact('totalUsers', 'recentUsers', 'pendingDeposits', 'totalDeposits'));
    }
}
