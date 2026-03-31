<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $referralCount = $user->referrals()->count();
        $referralLink = url('/register?ref=' . $user->referral_code);

        return view('user.profile', compact('user', 'referralCount', 'referralLink'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            $uploadedFile = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'oasisx/avatars',
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
            ]);
            $user->avatar = $uploadedFile->getSecurePath();
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
