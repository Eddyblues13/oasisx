<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'balance' => 'nullable|numeric|min:0',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'balance' => $validated['balance'] ?? 0,
        ]);

        return redirect()->route('admin.users.show', $user)->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->loadCount(['deposits', 'withdrawals', 'investments', 'loans', 'copyTrades', 'botSessions', 'referrals']);

        $recentDeposits = $user->deposits()->latest()->take(5)->get();
        $recentWithdrawals = $user->withdrawals()->latest()->take(5)->get();

        $stats = [
            'total_deposited' => $user->deposits()->where('status', 'approved')->sum('amount'),
            'total_withdrawn' => $user->withdrawals()->where('status', 'approved')->sum('amount'),
            'active_investments' => $user->investments()->where('status', 'active')->count(),
            'open_loans' => $user->loans()->whereIn('status', ['pending', 'approved'])->count(),
        ];

        return view('admin.users.show', compact('user', 'recentDeposits', 'recentWithdrawals', 'stats'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function fundAccount(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:credit,debit',
            'reason' => 'nullable|string|max:500',
        ]);

        $amount = $validated['amount'];

        if ($validated['type'] === 'debit') {
            if ($user->balance < $amount) {
                return back()->with('error', 'User does not have sufficient balance for this debit.');
            }
            $user->decrement('balance', $amount);
            $action = 'debited';
        } else {
            $user->increment('balance', $amount);
            $action = 'credited';
        }

        return back()->with('success', '$' . number_format($amount, 2) . " {$action} successfully.");
    }

    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);
        return back()->with('success', 'User has been suspended.');
    }

    public function unsuspend(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'User has been reactivated.');
    }

    public function ban(User $user)
    {
        $user->update(['status' => 'banned']);
        return back()->with('success', 'User has been banned.');
    }

    public function updateNotes(Request $request, User $user)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:2000']);
        $user->update(['admin_notes' => $request->admin_notes]);
        return back()->with('success', 'Admin notes updated.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($validated['new_password'])]);
        return back()->with('success', 'Password reset successfully.');
    }

    public function sendEmail(Request $request, User $user)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Mail::to($user->email)->send(new AdminUserMail($validated['subject'], $validated['message']));

        return back()->with('success', 'Email sent to ' . $user->email);
    }

    public function impersonate(User $user)
    {
        session()->put('admin_impersonating', auth('admin')->id());
        Auth::guard('web')->login($user);
        return redirect()->route('dashboard');
    }

    public function stopImpersonating()
    {
        $adminId = session()->pull('admin_impersonating');

        Auth::guard('web')->logout();

        if ($adminId) {
            Auth::guard('admin')->loginUsingId($adminId);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Returned to admin panel.');
    }
}
