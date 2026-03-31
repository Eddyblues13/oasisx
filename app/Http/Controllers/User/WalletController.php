<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\PaymentMethod;
use App\Models\Withdrawal;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected UploadApi $uploadApi;

    public function __construct()
    {
        $this->uploadApi = new UploadApi();
    }

    public function index()
    {
        $user = Auth::user();
        $paymentMethods = PaymentMethod::active()->get();

        $deposits = Deposit::where('user_id', $user->id)
            ->with('paymentMethod')
            ->latest()
            ->get()
            ->map(fn($d) => (object) [
                'date' => $d->created_at,
                'type' => 'deposit',
                'amount' => $d->amount,
                'method' => $d->paymentMethod->code ?? 'N/A',
                'status' => $d->status,
            ]);

        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(fn($w) => (object) [
                'date' => $w->created_at,
                'type' => 'withdrawal',
                'amount' => $w->amount,
                'method' => $w->method,
                'status' => $w->status,
            ]);

        $investments = Investment::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->get()
            ->map(fn($i) => (object) [
                'date' => $i->created_at,
                'type' => 'investment',
                'amount' => $i->amount,
                'method' => $i->plan->name ?? 'N/A',
                'status' => $i->status,
            ]);

        $transactions = $deposits->concat($withdrawals)->concat($investments)->sortByDesc('date')->values();

        return view('user.wallet', compact('paymentMethods', 'transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $proofUrl = null;
        $proofPublicId = null;

        if ($request->hasFile('proof')) {
            $uploadResult = $this->uploadApi->upload(
                $request->file('proof')->getRealPath(),
                [
                    'folder' => 'oasisx/deposit_proofs',
                    'transformation' => [
                        'width' => 800,
                        'height' => 600,
                        'crop' => 'limit',
                    ],
                ]
            );
            $proofUrl = $uploadResult['secure_url'];
            $proofPublicId = $uploadResult['public_id'];
        }

        Deposit::create([
            'user_id' => Auth::id(),
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'proof_url' => $proofUrl,
            'proof_public_id' => $proofPublicId,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Deposit request submitted successfully. It will be reviewed shortly.');
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'amount' => 'required|numeric|min:100',
            'method' => 'required|string|max:50',
            'details' => 'nullable|string|max:1000',
        ]);

        if ($request->amount > $user->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance. Your available balance is $' . number_format($user->balance, 2) . '.']);
        }

        // Deduct balance immediately (held until admin approves or rejects)
        $user->decrement('balance', $request->amount);

        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted successfully. It will be reviewed shortly.');
    }

    public function resolveAccount(Request $request)
    {
        $request->validate([
            'bank_code' => 'required|string',
            'account_number' => 'required|string|min:10',
        ]);

        // TODO: Integrate with Flutterwave API
        return response()->json([
            'status' => 'error',
            'message' => 'Account resolution not yet configured.',
        ]);
    }
}
