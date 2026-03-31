<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BotSession;
use Illuminate\Http\Request;

class BotSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = BotSession::with(['user', 'tradingBot'])->latest();

        if ($request->has('status') && in_array($request->status, ['running', 'stopped', 'completed'])) {
            $query->where('status', $request->status);
        }

        $botSessions = $query->paginate(20);

        return view('admin.bot-sessions.index', compact('botSessions'));
    }
}
