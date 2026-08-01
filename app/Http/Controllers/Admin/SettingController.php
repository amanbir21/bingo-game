<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Inertia\Inertia;

class SettingController extends Controller
{

    public function index()
    {

        $settings = Setting::all();


        return Inertia::render(
            'Admin/Settings/Index',
            [
                'settings' => $settings
            ]
        );

    }


}