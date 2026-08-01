<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Winner extends Model
{
    use HasFactory;


    protected $fillable = [

        'game_id',
        'user_id',
        'card_id',
        'pattern_id',
        'prize_amount',
        'claimed_at',
        'verified_by',

    ];


    protected $casts = [

        'prize_amount' => 'decimal:2',

        'claimed_at' => 'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Winner belongs to a game
    public function game()
    {
        return $this->belongsTo(Game::class);
    }


    // Winner belongs to a player
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Winner belongs to bingo card
    public function card()
    {
        return $this->belongsTo(
            BingoCard::class,
            'card_id'
        );
    }


    // Winner belongs to winning pattern
    public function pattern()
    {
        return $this->belongsTo(
            GamePattern::class,
            'pattern_id'
        );
    }


    // Admin who verified winner
    public function verifier()
    {
        return $this->belongsTo(
            User::class,
            'verified_by'
        );
    }

}