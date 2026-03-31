<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        return view('auth.register', ['ref' => $request->query('ref')]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ref' => ['nullable', 'string'],
        ]);

        $referrerId = null;
        if ($request->filled('ref')) {
            $referrer = User::where('referral_code', $request->ref)->first();
            if ($referrer) {
                $referrerId = $referrer->id;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referred_by' => $referrerId,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
