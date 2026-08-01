<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\GamePlayer;
use App\Models\BingoCard;
use App\Models\Winner;
use App\Services\BingoChecker;
//use App\Events\BingoNumberDrawn;

class GameController extends Controller
{


public function index()
{

    return Inertia::render(
        'Admin/Games/Index',
        [

            'games'=>Game::withCount('players')
                ->latest()
                ->get()

        ]
    );

}




public function create()
{

    return Inertia::render(
        'Admin/Games/Create'
    );

}





public function store(Request $request)
{
    $request->validate([

        'title' => 'required|string|max:255',

        'ticket_price' => 'required|numeric|min:0',

        'prize_percentage' => 'required|numeric|min:0|max:100',

        'minimum_players' => 'required|integer|min:2',

        'maximum_players' => 'required|integer|gt:minimum_players',

        'started_at' => 'required|date',

    ]);


    Game::create([

        'game_code' =>
            'BG-'.date('Ymd').'-'.strtoupper(Str::random(4)),

        'title' => $request->title,

        'description' => $request->description,

        'ticket_price' => $request->ticket_price,

        'prize_percentage' => $request->prize_percentage,

        'minimum_players' => $request->minimum_players,

        'maximum_players' => $request->maximum_players,

        'draw_interval' => $request->draw_interval ?? 5,

        'status' => 'waiting',

        'started_at' => $request->started_at,

        'created_by' => auth()->id(),

    ]);


    return redirect()
        ->route('games.index')
        ->with('success','Game created successfully');
}






public function edit(Game $game)
{

    return Inertia::render(
        'Admin/Games/Edit',
        [
            'game'=>$game
        ]
    );

}





public function update(Request $request, Game $game)
{

    $request->validate([

        'title'=>'required',

        'ticket_price'=>'required|numeric',

        'maximum_players'=>'required|integer',

    ]);



    $game->update($request->all());



    return redirect()
        ->route('games.index');

}





public function destroy(Game $game)
{

    $game->delete();


    return back();

}
public function show(Game $game)
{
    $game->load([
        'players',
        'drawnNumbers',
    ]);


    $winner = Winner::with([
        'user',
        'pattern',
        'card'
    ])
    ->where('game_id', $game->id)
    ->first();



    return Inertia::render('Admin/Games/Show',[

        'game'=>$game,


        'players'=>$game->players->map(function($player){

            return [
                'id'=>$player->id,
                'name'=>$player->name,
            ];

        }),


        'drawnNumbers'=>$game->drawnNumbers
            ->sortBy('draw_order')
            ->values(),


        'winner'=>$winner,


        'noWinner'=>(
            $game->status === 'finished'
            &&
            $winner === null
        ),

    ]);
}


public function start(Game $game)
{
    // Clear previous game data
    $game->drawnNumbers()->delete();
    Winner::where('game_id', $game->id)->delete();

    // Generate new tickets for all players
    $players = GamePlayer::where('game_id', $game->id)->get();

    foreach ($players as $player) {

        $newCard = $this->generateUniqueCard($game->id);

        BingoCard::updateOrCreate(
            [
                'game_id' => $game->id,
                'user_id' => $player->user_id,
            ],
            [
                'numbers' => $newCard['numbers'],
                'card_hash' => $newCard['hash'],
                'is_winner' => false,
            ]
        );

        // Optional: generate a new ticket number
        $player->update([
            'ticket_number' => 'BINGO-' . strtoupper(Str::random(10)),
            'status' => 'joined',
            'prize_paid' => false,
        ]);
    }

    $game->update([
        'status' => 'running',
        'started_at' => now(),
        'ended_at' => null,
        'winner_id' => null,
    ]);

    return back()->with('success', 'Game restarted successfully.');
}
public function draw(Game $game)
{
    try {

        if($game->status !== 'running'){

            return response()->json([
                'success'=>false,
                'message'=>'Game is not running'
            ]);

        }


        $usedNumbers = $game->drawnNumbers()
            ->pluck('number')
            ->toArray();



        // Get available numbers
        $available = array_diff(
            range(1,75),
            $usedNumbers
        );


        if(count($available) == 0){

            $game->update([
                'status'=>'finished',
                'ended_at'=>now()
            ]);

            return response()->json([
                'success'=>true,
                'finished'=>true,
                'message'=>'All numbers finished',
                'draw'=>null
            ]);

        }



        // Draw random number
        $number = $available[array_rand($available)];



        $column = match(true){

            $number <=15 =>'B',

            $number <=30 =>'I',

            $number <=45 =>'N',

            $number <=60 =>'G',

            default =>'O'

        };



        // Save number
        $draw = $game->drawnNumbers()->create([

            'column'=>$column,

            'number'=>$number,

            'draw_order'=>count($usedNumbers)+1,

            'drawn_at'=>now(),

        ]);



        // Check winner after this draw
        $result = $this->findWinner($game);



        // Winner found
        if($result['status']){


            $game->update([

                'status'=>'finished',

                'winner_id'=>$result['winner']->user_id,

                'ended_at'=>now(),

            ]);


            return response()->json([

                'success'=>true,

                'finished'=>true,

                'draw'=>$draw,

                'winner'=>$result['winner'],

                'noWinner'=>false

            ]);

        }



        // No winner but reached 24 numbers
        $totalDraws = $game->drawnNumbers()->count();


        if($totalDraws >= 24){


            $game->update([

                'status'=>'finished',

                'winner_id'=>null,

                'ended_at'=>now(),

            ]);


            return response()->json([

                'success'=>true,

                'finished'=>true,

                'draw'=>$draw,

                'winner'=>null,

                'noWinner'=>true,

                'message'=>'Game finished. No winner.'

            ]);

        }



        // Continue game
        return response()->json([

            'success'=>true,

            'finished'=>false,

            'draw'=>$draw

        ]);



    } catch(\Exception $e){


        return response()->json([

            'success'=>false,

            'error'=>$e->getMessage()

        ],500);


    }
}
public function finish(Game $game)
{
    $totalSales = $game->ticket_price * $game->players()->count();

    $finalPrize = $totalSales * ($game->prize_percentage / 100);


    $game->update([
        'status'=>'finished',
        'ended_at'=>now(),
        'total_sales'=>$totalSales,
        'tickets_sold'=>$game->players()->count(),
        'final_prize'=>$finalPrize,
    ]);


    $result = $this->findWinner($game);


    if(!$result['status']){

        $game->update([
            'winner_id'=>null
        ]);

    }


    return back();
}
private function findWinner(Game $game)
{

    $oldWinner = Winner::with('user')
        ->where('game_id',$game->id)
        ->first();



    if($oldWinner){

        return [

            'status'=>true,

            'winner'=>$oldWinner

        ];

    }



    $drawnNumbers = $game->drawnNumbers()
        ->pluck('number')
        ->map(fn($n)=>(int)$n)
        ->toArray();



    $players = GamePlayer::where(
        'game_id',
        $game->id
    )->get();



    foreach($players as $player){


        $card = BingoCard::where('game_id',$game->id)
            ->where('user_id',$player->user_id)
            ->first();



        if(!$card){

            continue;

        }



        $numbers = $card->numbers;



        if(is_string($numbers)){

            $numbers=json_decode($numbers,true);

        }



        foreach($numbers as $r=>$row){

            foreach($row as $c=>$value){

                if($value=="FREE"){

                    $numbers[$r][$c]=0;

                }

            }

        }




        $patterns=[

            'horizontal'=>1,

            'vertical'=>2,

            'diagonal'=>3,

            'four_corners'=>4,

            'full_house'=>5,

        ];




        foreach($patterns as $pattern=>$patternId){


            if(
                BingoChecker::check(
                    $numbers,
                    $drawnNumbers,
                    $pattern
                )
            ){



                $winner = Winner::create([

                    'game_id'=>$game->id,

                    'user_id'=>$player->user_id,

                    'card_id'=>$card->id,

                    'pattern_id'=>$patternId,

                    'prize_amount'=>$game->final_prize 
                        ?? $game->prize_pool

                ]);



                $winner->load([
                    'user',
                    'pattern'
                ]);




                $game->update([

                    'winner_id'=>$player->user_id,

                    'status'=>'finished',

                    'ended_at'=>now()

                ]);



                return [

                    'status'=>true,

                    'winner'=>$winner

                ];


            }


        }


    }



    return [

        'status'=>false,

        'winner'=>null

    ];

}
private function generateUniqueCard($gameId)
{
    do {

        $card = $this->generateCard();

        $hash = md5(json_encode($card));

        $exists = BingoCard::where('game_id', $gameId)
            ->where('card_hash', $hash)
            ->exists();

    } while ($exists);

    return [
        'numbers' => $card,
        'hash' => $hash,
    ];
}

private function generateCard()
{
    $columns = [

        collect(range(1,15))->shuffle()->take(5)->values(),

        collect(range(16,30))->shuffle()->take(5)->values(),

        collect(range(31,45))->shuffle()->take(5)->values(),

        collect(range(46,60))->shuffle()->take(5)->values(),

        collect(range(61,75))->shuffle()->take(5)->values(),

    ];

    $card = [];

    for ($i = 0; $i < 5; $i++) {

        $card[] = [
            $columns[0][$i],
            $columns[1][$i],
            $i == 2 ? 'FREE' : $columns[2][$i],
            $columns[3][$i],
            $columns[4][$i],
        ];
    }

    return $card;
}
}