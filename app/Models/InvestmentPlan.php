<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'amount',
        'roi_percentage',
        'duration_days',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'roi_percentage' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function getExpectedPayoutAttribute(): float
    {
        return $this->amount + ($this->amount * $this->roi_percentage / 100);
    }
}
