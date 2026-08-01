<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * Fields allowed for mass assignment
     */
   protected $fillable = [

    'name',
    'email',
    'phone',
    'password',
    'role',
    'is_active',
    'profile_photo',
    'last_login_at',

];


    /**
     * Hidden fields
     */
    protected $hidden = [

        'password',
        'remember_token',

    ];


    /**
     * Data type casting
     */
    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',

            'last_login_at' => 'datetime',

            'password' => 'hashed',

            'is_active' => 'boolean',

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // User has one wallet
   public function wallet()
{
    return $this->hasOne(Wallet::class);
}


    // User has many wallet transactions
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }


    // User has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    // User has many withdrawals
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }


    // User joins many games
    public function games()
    {
        return $this->belongsToMany(
            Game::class,
            'game_players'
        )
        ->withPivot('status','joined_at')
        ->withTimestamps();
    }


    // User owns many bingo cards
    public function bingoCards()
    {
        return $this->hasMany(BingoCard::class);
    }


    // User has many wins
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }

    public function gamePlayers()
{
    return $this->hasMany(\App\Models\GamePlayer::class);
}
public function tickets()
{
    return $this->hasMany(BingoCard::class, 'user_id');
}

    // User activity logs
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }



    /*
    |--------------------------------------------------------------------------
    | Role Helpers
    |--------------------------------------------------------------------------
    */


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }


    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }


    public function isActive(): bool
    {
        return $this->is_active === true;
    }
protected static function booted()
{
    static::created(function ($user) {

        $user->wallet()->create([
            'balance' => 0,
            'status' => true,
        ]);

    });
}
}