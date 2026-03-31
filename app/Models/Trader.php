<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trader extends Model
{
    protected $fillable = [
        'name',
        'trader_name',
        'description',
        'avatar',
        'daily_roi',
        'min_amount',
        'max_amount',
        'risk_level',
        'is_active',
    ];

    protected $casts = [
        'daily_roi' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function copyTrades()
    {
        return $this->hasMany(CopyTrade::class);
    }
}
