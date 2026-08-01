<?php
namespace App\Http\Controllers;
use App\Models\Winner;
use App\Models\GamePattern;
use App\Models\BingoCard;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Services\BingoChecker;

//use App\Models\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class PlayerGameController extends Controller
{

public function index()
{

 return Inertia::render('Players/Dashboard', [
    'activeGames' => Game::where('status', 'open')->count(),

    'games' => Game::where('status', 'running')
        ->select('id', 'title', 'ticket_price')
        ->get(),

    'recentGames' => Game::latest()->take(10)->get(),

    'tickets' => 0,
    'winnings' => 0,

    'wallet' => [
        'balance' => 0,
        'deposit' => 0,
        'withdraw' => 0,
    ],
]);

}

public function show(Game $game)
{
    $game->load([
        'drawnNumbers',
        'winner.user',
        'winner.card',
    ]);


    $user = auth()->user();


    $card = BingoCard::where('game_id',$game->id)
        ->where('user_id',$user->id)
        ->first();


    $hasWinner = Winner::where('game_id',$game->id)->exists();


    $noWinner = false;


    if($game->status === 'finished' && !$hasWinner){

        $noWinner = true;

    }


    return Inertia::render('Players/GameRoom', [

        'game'=>$game,

        'card'=>$card?->numbers ?? [],

        'winner'=>$game->winner,

        'noWinner'=>$noWinner,

        'drawnNumbers'=>$game->drawnNumbers
            ->sortBy('draw_order')
            ->pluck('number')
            ->toArray(),

    ]);
}
public function claim(Game $game)
{
    $user = auth()->user();

    //$game->load('pattern');


    $card = BingoCard::where('game_id', $game->id)
        ->where('user_id', $user->id)
        ->first();


    if (!$card) {
        return redirect()
            ->route('player.tickets')
            ->with('error', 'No ticket found.');
    }


    // Check if already has winner
    if (Winner::where('game_id', $game->id)->exists()) {

        return redirect()
            ->route('player.tickets')
            ->with('error', 'This game already has a winner.');

    }


    $drawnNumbers = $game->drawnNumbers()
        ->pluck('number')
        ->toArray();


    // Selected game pattern
 $pattern = GamePattern::where('code', 'full_house')->first();

if (!$pattern) {
    return redirect()
        ->route('player.tickets')
        ->with('error', 'Winning pattern not found.');
}


   $isWinner = match($pattern->code) {

    'horizontal' => $this->checkHorizontal(
        $card->numbers,
        $drawnNumbers
    ),

    'vertical' => $this->checkVertical(
        $card->numbers,
        $drawnNumbers
    ),

    'diagonal' => $this->checkDiagonal(
        $card->numbers,
        $drawnNumbers
    ),

    'four_corners' => $this->checkCorners(
        $card->numbers,
        $drawnNumbers
    ),

    'full_house' => $this->checkFullHouse(
        $card->numbers,
        $drawnNumbers
    ),

    default => false,
};

    if (!$isWinner) {

        return redirect()
            ->route('player.tickets')
            ->with('error', 'No Bingo yet.');

    }



    // Update game

    $game->update([

        'winner_id' => $user->id,

        'status' => 'finished',

        'ended_at' => now(),

    ]);



    // Update card

    $card->update([

        'is_winner' => true,

    ]);



    // Save winner

    Winner::create([

        'game_id' => $game->id,

        'user_id' => $user->id,

        'card_id' => $card->id,

        'pattern_id' => $pattern->id,

        'prize_amount' => $game->final_prize ?? 0,

    ]);



    return redirect()
        ->route('player.tickets')
        ->with('success', '🎉 Congratulations! You won!');
}

private function checkFullHouse($card, $drawnNumbers)
{
    foreach($card as $row){

        foreach($row as $number){

            if(
                $number !== 'FREE' &&
                !in_array($number,$drawnNumbers)
            ){
                return false;
            }

        }

    }

    return true;
}
public function join(Game $game)
{
    try {

        $user = auth()->user();


        // Prevent joining finished games
        if ($game->status === 'finished') {

            return redirect()
                ->route('player.dashboard')
                ->with('error', 'This game has already finished. You cannot join.');

        }


        // Check duplicate join
        if (GamePlayer::where('game_id', $game->id)
            ->where('user_id', $user->id)
            ->exists()) {


            return redirect()
                ->route('player.dashboard')
                ->with('error', 'You already joined this game.');

        }



        GamePlayer::create([

            'game_id'       => $game->id,

            'user_id'       => $user->id,

            'ticket_number' => 'BINGO-' . strtoupper(Str::random(10)),

            'ticket_price'  => $game->ticket_price,

            'joined_at'     => now(),

            'status'        => 'joined',

            'prize_paid'    => false,

        ]);



        $card = $this->generateUniqueCard($game->id);



        BingoCard::create([

            'game_id'   => $game->id,

            'user_id'   => $user->id,

            'numbers'   => $card['numbers'],

            'card_hash' => $card['hash'],

        ]);



        return redirect()
            ->route('player.dashboard')
            ->with('success', 'You joined successfully.');


    } catch (\Exception $e) {


        return redirect()
            ->route('player.dashboard')
            ->with('error', $e->getMessage());

    }
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

        collect(range(1, 15))->shuffle()->take(5)->values(),

        collect(range(16, 30))->shuffle()->take(5)->values(),

        collect(range(31, 45))->shuffle()->take(5)->values(),

        collect(range(46, 60))->shuffle()->take(5)->values(),

        collect(range(61, 75))->shuffle()->take(5)->values(),

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




public function tickets()
{
    $tickets = GamePlayer::with([
        'game',
    ])
    ->where('user_id', auth()->id())
    ->latest()
    ->get();


    $tickets->each(function ($ticket) {

        $ticket->winner = Winner::where('game_id', $ticket->game_id)
            ->where('user_id', auth()->id())
            ->first();

    });


    return Inertia::render('Players/Tickets', [
        'tickets' => $tickets,
    ]);
}


public function changeTicket(Game $game)
{
  
    $user = auth()->user();


     if ($game->drawnNumbers()->count() > 0) {
    return response()->json([
        'success' => false,
        'message' => 'The game has already started.',
    ]);
}


    $card = BingoCard::where('game_id', $game->id)
        ->where('user_id', $user->id)
        ->first();


    if (!$card) {

        return response()->json([
            'success' => false,
            'message' => 'Ticket not found.',
        ]);

    }


    $newCard = $this->generateUniqueCard($game->id);


    $card->update([
        'numbers' => $newCard['numbers'],
        'card_hash' => $newCard['hash'],
        'is_winner' => false,
    ]);


    return response()->json([
        'success' => true,
        'message' => '🎲 Ticket changed successfully.',
        'card' => $newCard['numbers'],
    ]);
}
/*
public function tickets()
{
    $tickets = GamePlayer::with('game')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return Inertia::render('Players/Tickets', [
        'tickets' => $tickets,
    ]);
}*/
private function checkWinner($card, $drawnNumbers)
{
    // Get bingo card numbers
    $numbers = $card->numbers;


    // Make sure JSON is converted to array
    if (is_string($numbers)) {
        $numbers = json_decode($numbers, true);
    }


    // Convert drawn numbers to integers
    $drawnNumbers = array_map('intval', $drawnNumbers);



    // FREE center
    $numbers[2][2] = 0;



    // =====================
    // Rows
    // =====================

    foreach ($numbers as $row) {

        $count = 0;

        foreach ($row as $num) {

            if ($num == 0 || in_array((int)$num, $drawnNumbers)) {
                $count++;
            }

        }


        if ($count == 5) {
            return true;
        }

    }



    // =====================
    // Columns
    // =====================

    for ($col = 0; $col < 5; $col++) {

        $count = 0;


        for ($row = 0; $row < 5; $row++) {

            $num = $numbers[$row][$col];


            if ($num == 0 || in_array((int)$num, $drawnNumbers)) {
                $count++;
            }

        }


        if ($count == 5) {
            return true;
        }

    }



    // =====================
    // Diagonal top-left to bottom-right
    // =====================

    $count = 0;


    for ($i = 0; $i < 5; $i++) {

        $num = $numbers[$i][$i];


        if ($num == 0 || in_array((int)$num, $drawnNumbers)) {
            $count++;
        }

    }


    if ($count == 5) {
        return true;
    }



    // =====================
    // Diagonal top-right to bottom-left
    // =====================

    $count = 0;


    for ($i = 0; $i < 5; $i++) {

        $num = $numbers[$i][4-$i];


        if ($num == 0 || in_array((int)$num, $drawnNumbers)) {
            $count++;
        }

    }


    if ($count == 5) {
        return true;
    }



    // No winner
    return false;
}
}