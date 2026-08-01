<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BingoNumberDrawn implements ShouldBroadcast
{

    use Dispatchable, SerializesModels;


    public $draw;


    public function __construct($draw)
    {
        $this->draw = $draw;
    }



    public function broadcastOn()
    {
        return new Channel(
            'game.'.$this->draw->game_id
        );
    }



    public function broadcastAs()
    {
        return 'number.drawn';
    }

}