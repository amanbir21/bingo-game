<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

protected $fillable = [
    'game_code',
    'title',
    'description',
    'ticket_price',
    'prize_percentage',
    'minimum_players',
    'maximum_players',
    'draw_interval',
    'status',
    'final_prize',
    'total_sales',
    'tickets_sold',
    'started_at',
    'ended_at',
    'created_by',
    'winner_id',
];

   protected $casts = [
    'ticket_price' => 'decimal:2',
    'prize_percentage' => 'decimal:2',
    'final_prize' => 'decimal:2',
    'total_sales' => 'decimal:2',
    'started_at' => 'datetime',
    'ended_at' => 'datetime',
];

 protected $appends = [
        'prize_pool',
    ];

    // Admin creator
    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }



    // Players
    public function players()
    {
        return $this->belongsToMany(
            User::class,
            'game_players'
        )
        ->withPivot(
            'status',
            'joined_at'
        )
        ->withTimestamps();
    }



    public function gamePlayers()
    {
        return $this->hasMany(
            GamePlayer::class
        );
    }



    public function bingoCards()
    {
        return $this->hasMany(
            BingoCard::class
        );
    }



public function drawnNumbers()
{
    return $this->hasMany(
        DrawnNumber::class,
        'game_id'
    );
}



public function winner()
{
    return $this->hasOne(
        Winner::class,
        'game_id'
    );
}


    // Helpers

    public function isWaiting()
    {
        return $this->status === 'waiting';
    }


    public function isRunning()
    {
        return $this->status === 'running';
    }


    public function playerCount()
{
    return $this->gamePlayers()->count();
}


    public function canStart()
    {
        return $this->playerCount()
            >= $this->minimum_players;
    }


    public function canJoin()
    {
        return $this->status === 'waiting'
            &&
            $this->playerCount()
            < $this->maximum_players;
    }
   public function getPrizePoolAttribute()
{
    $totalSales = $this->ticket_price * $this->playerCount();

    return round(
        $totalSales * ($this->prize_percentage / 100),
        2
    );
}

}