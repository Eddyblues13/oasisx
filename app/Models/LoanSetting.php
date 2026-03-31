<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanSetting extends Model
{
    protected $fillable = [
        'max_open_loans',
        'max_ltv',
        'daily_interest_rate',
        'is_enabled',
    ];

    protected $casts = [
        'max_ltv' => 'decimal:2',
        'daily_interest_rate' => 'decimal:2',
        'is_enabled' => 'boolean',
    ];

    public static function current()
    {
        return static::first() ?? static::create([]);
    }
}
