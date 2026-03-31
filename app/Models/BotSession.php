<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotSession extends Model
{
    protected $fillable = [
        'user_id',
        'trading_bot_id',
        'amount',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tradingBot()
    {
        return $this->belongsTo(TradingBot::class);
    }

    public function scopeRunning($query)
    {
        return $query->where('status', 'running');
    }
}
