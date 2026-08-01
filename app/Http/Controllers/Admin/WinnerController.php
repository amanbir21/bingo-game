<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Winner;
use Inertia\Inertia;

class WinnerController extends Controller
{

   public function index()
{
    $winners = Winner::with([
        'user',
        'game',
        'pattern',
        'card'
    ])
    ->latest()
    ->get();
//dd($winners); // TEST


    return Inertia::render(
        'Admin/Winners/Index',
        [
            'winners' => $winners
        ]
    );
}

}