<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {

        Setting::insert([

            [
                'key'=>'currency',
                'value'=>'ETB',
                'description'=>'System currency'
            ],

            [
                'key'=>'ticket_price',
                'value'=>'10',
                'description'=>'Default bingo ticket price'
            ],

            [
                'key'=>'draw_interval',
                'value'=>'5',
                'description'=>'Seconds between drawn numbers'
            ],

            [
                'key'=>'minimum_withdraw',
                'value'=>'100',
                'description'=>'Minimum withdrawal amount'
            ],

            [
                'key'=>'maintenance_mode',
                'value'=>'false',
                'description'=>'System maintenance status'
            ],

        ]);

    }
}