<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletConnection extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'network',
        'address',
        'label',
        'status',
        'daily_reward',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
