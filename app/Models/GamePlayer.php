<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GamePlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'ticket_number',
        'ticket_price',
        'status',
        'prize_paid',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bingoCard()
    {
        return $this->hasOne(BingoCard::class);
    }

    public function winner()
    {
        return $this->hasOne(Winner::class, 'user_id', 'user_id')
            ->whereColumn('game_id', 'game_players.game_id');
    }
}