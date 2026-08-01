<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class PlayerController extends Controller
{

    public function index()
    {

        $players = User::where('role','player')
            ->latest()
            ->get();


        return Inertia::render(
            'Admin/Players/Index',
            [
                'players'=>$players
            ]
        );

    }


}