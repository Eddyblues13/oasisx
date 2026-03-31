<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'admin_note',
        'outstanding_amount',
        'approved_at',
        'repaid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'repaid_at' => 'datetime',
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

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['pending', 'approved']);
    }
}
