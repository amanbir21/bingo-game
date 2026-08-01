<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\WinnerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\PlayerGameController;


Route::middleware(['auth'])->prefix('admin')->group(function () {


    // Dashboard
    Route::get('/dashboard',
        [DashboardController::class,'index']
    )->name('admin.dashboard');


    // Games
    Route::resource('games',
        GameController::class
    );


    // Players
    Route::get('/players',
        [PlayerController::class,'index']
    )->name('admin.players');


    // Payments
    Route::get('/payments',
        [PaymentController::class,'index']
    )->name('admin.payments');


    // Winners
    Route::get('/winners',
        [WinnerController::class,'index']
    )->name('admin.winners');


    // Settings
    Route::get('/settings',
        [SettingController::class,'index']
    )->name('admin.settings');


    #show
    Route::post('/games/{game}/start',
[GameController::class,'start'])
->name('games.start');


Route::post('/games/{game}/draw',
[GameController::class,'draw'])
->name('games.draw');



Route::post('/games/{game}/finish',
[GameController::class,'finish'])
->name('games.finish');
});


#player 
Route::middleware('auth')
->prefix('player')
->group(function(){

    Route::get('/dashboard',
        [PlayerGameController::class,'index']
    )->name('player.dashboard');


    Route::get('/games/{game}',
        [PlayerGameController::class,'show']
    )->name('player.games.show');


    Route::post('/games/{game}/join',
        [PlayerGameController::class,'join']
    )->name('player.games.join');


    Route::post('/games/{game}/claim',
        [PlayerGameController::class,'claim']
    )->name('player.claim');


    Route::get('/tickets',
        [PlayerGameController::class,'tickets']
    )->name('player.tickets');


    Route::post('/games/{game}/change-ticket',
        [PlayerGameController::class,'changeTicket']
    )->name('player.games.change-ticket');

});
Route::get('/', function () {

    return Inertia::render('Welcome', [

        'canLogin' => Route::has('login'),

        'canRegister' => Route::has('register'),

        'games' => \App\Models\Game::withCount('players')
            ->whereIn('status', [
                'waiting',
                'running'
            ])
            ->latest()
            ->get(),

    ]);

});
/*
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

require __DIR__.'/auth.php';
