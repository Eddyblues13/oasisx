<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingBot extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'runtime_hours',
        'hourly_roi',
        'min_amount',
        'max_amount',
        'max_concurrent',
        'is_active',
    ];

    protected $casts = [
        'hourly_roi' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function botSessions()
    {
        return $this->hasMany(BotSession::class);
    }
}
