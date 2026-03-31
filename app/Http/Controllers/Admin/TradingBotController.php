<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingBot;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class TradingBotController extends Controller
{
    public function index()
    {
        $bots = TradingBot::latest()->get();

        return view('admin.trading-bots.index', compact('bots'));
    }

    public function create()
    {
        return view('admin.trading-bots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:2048',
            'runtime_hours' => 'required|integer|min:1',
            'hourly_roi' => 'required|numeric|min:0.01|max:100',
            'min_amount' => 'required|numeric|min:0.01',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'max_concurrent' => 'required|integer|min:1|max:10',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'oasisx/bots',
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill',
                ],
            ]);
            $imageUrl = $uploaded->getSecurePath();
        }

        TradingBot::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageUrl,
            'runtime_hours' => $request->runtime_hours,
            'hourly_roi' => $request->hourly_roi,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'max_concurrent' => $request->max_concurrent,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.trading-bots.index')->with('success', 'Trading bot created successfully.');
    }

    public function edit(TradingBot $tradingBot)
    {
        return view('admin.trading-bots.edit', compact('tradingBot'));
    }

    public function update(Request $request, TradingBot $tradingBot)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:2048',
            'runtime_hours' => 'required|integer|min:1',
            'hourly_roi' => 'required|numeric|min:0.01|max:100',
            'min_amount' => 'required|numeric|min:0.01',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'max_concurrent' => 'required|integer|min:1|max:10',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'runtime_hours' => $request->runtime_hours,
            'hourly_roi' => $request->hourly_roi,
            'min_amount' => $request->min_amount,
            'max_amount' => $request->max_amount,
            'max_concurrent' => $request->max_concurrent,
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'oasisx/bots',
                'transformation' => [
                    'width' => 200,
                    'height' => 200,
                    'crop' => 'fill',
                ],
            ]);
            $data['image'] = $uploaded->getSecurePath();
        }

        $tradingBot->update($data);

        return redirect()->route('admin.trading-bots.index')->with('success', 'Trading bot updated successfully.');
    }

    public function destroy(TradingBot $tradingBot)
    {
        $tradingBot->delete();

        return redirect()->route('admin.trading-bots.index')->with('success', 'Trading bot deleted successfully.');
    }
}
