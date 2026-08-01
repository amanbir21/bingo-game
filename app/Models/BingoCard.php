<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BingoCard extends Model
{

    protected $fillable = [
        'game_id',
        'user_id',
        'numbers',
        'card_hash',
        'is_winner',
    ];


    protected $casts = [
        'numbers' => 'array',
        'is_winner' => 'boolean',
    ];


    public function game()
    {
        return $this->belongsTo(Game::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function winner()
    {
        return $this->hasOne(Winner::class);
    }

}