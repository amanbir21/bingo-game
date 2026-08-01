<?php

namespace Database\Seeders;

use App\Models\GamePattern;
use Illuminate\Database\Seeder;

class GamePatternSeeder extends Seeder
{
    public function run(): void
    {

        GamePattern::insert([

            [
                'name'=>'Horizontal',
                'code'=>'horizontal',
                'description'=>'Complete horizontal row',
                'is_active'=>true
            ],

            [
                'name'=>'Vertical',
                'code'=>'vertical',
                'description'=>'Complete vertical column',
                'is_active'=>true
            ],

            [
                'name'=>'Diagonal',
                'code'=>'diagonal',
                'description'=>'Complete diagonal line',
                'is_active'=>true
            ],

            [
                'name'=>'Four Corners',
                'code'=>'four_corners',
                'description'=>'Match all four corners',
                'is_active'=>true
            ],

            [
                'name'=>'Full House',
                'code'=>'full_house',
                'description'=>'Complete all numbers',
                'is_active'=>true
            ],

        ]);

    }
}