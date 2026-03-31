<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CopyTrade extends Model
{
    protected $fillable = [
        'user_id',
        'trader_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
