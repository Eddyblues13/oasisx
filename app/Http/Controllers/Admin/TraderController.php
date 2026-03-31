<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trader;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    public function index()
    {
        $traders = Trader::latest()->get();

        return view('admin.traders.index', compact('traders'));
    }

    public function create()
    {
        return view('admin.traders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'trader_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'avatar' => 'nullable|image|max:2048',
            'daily_roi' => 'required|numeric|min:0.01|max:100',
            'min_amount' => 'required|numeric|min:0.01',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'risk_level' => 'required|in:low,medium,high',
        ]);

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $uploaded = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'oasisx/traders',
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
            ]);
            $avatarUrl = $uploaded->getSecurePath();
        }

        Trader::create([
            'name' => $request->name,
            'trader_name' => $request->trader_name,
            'description' => $request->description,
            'avatar' => $avatarUrl,
            'daily_roi' => $request->daily_roi,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'risk_level' => $request->risk_level,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.traders.index')->with('success', 'Trader created successfully.');
    }

    public function edit(Trader $trader)
    {
        return view('admin.traders.edit', compact('trader'));
    }

    public function update(Request $request, Trader $trader)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'trader_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'avatar' => 'nullable|image|max:2048',
            'daily_roi' => 'required|numeric|min:0.01|max:100',
            'min_amount' => 'required|numeric|min:0.01',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'risk_level' => 'required|in:low,medium,high',
        ]);

        $data = [
            'name' => $request->name,
            'trader_name' => $request->trader_name,
            'description' => $request->description,
            'daily_roi' => $request->daily_roi,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'risk_level' => $request->risk_level,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('avatar')) {
            $uploaded = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'oasisx/traders',
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
            ]);
            $data['avatar'] = $uploaded->getSecurePath();
        }

        $trader->update($data);

        return redirect()->route('admin.traders.index')->with('success', 'Trader updated successfully.');
    }

    public function destroy(Trader $trader)
    {
        $trader->delete();

        return redirect()->route('admin.traders.index')->with('success', 'Trader deleted successfully.');
    }
}
