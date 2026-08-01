<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Game;
use App\Models\Payment;
use Inertia\Inertia;


class DashboardController extends Controller
{

public function index()
{

return Inertia::render('Admin/Dashboard',[


'players'=>User::where('role','player')->count(),

'games'=>Game::count(),

'activeGames'=>Game::where(
'status',
'running'
)->count(),


'revenue'=>Payment::where(
'status',
'completed'
)->sum('amount')


]);


}

}