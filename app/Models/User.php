<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'phone',
        'avatar',
        'referral_code',
        'referred_by',
        'status',
        'admin_notes',
    ];

    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            }
        });
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function walletConnections()
    {
        return $this->hasMany(WalletConnection::class);
    }

    public function copyTrades()
    {
        return $this->hasMany(CopyTrade::class);
    }

    public function botSessions()
    {
        return $this->hasMany(BotSession::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
