<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrawnNumber extends Model
{
    use HasFactory;


 protected $fillable = [

    'game_id',
    'column',
    'number',
    'draw_order',
    'drawn_at',

];


    protected $casts = [

        'drawn_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Drawn number belongs to a game
    public function game()
    {
        return $this->belongsTo(Game::class);
    }



    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    // Get full bingo number format
    public function getDisplayNumberAttribute()
    {
        return $this->column . '-' . $this->number;
    }

}