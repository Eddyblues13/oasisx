<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'user_id',
        'investment_plan_id',
        'amount',
        'roi_percentage',
        'expected_payout',
        'duration_days',
        'status',
        'admin_note',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'roi_percentage' => 'decimal:2',
            'expected_payout' => 'decimal:2',
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(InvestmentPlan::class, 'investment_plan_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
