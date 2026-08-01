<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {

        PaymentMethod::insert([

            [
                'name'=>'Chapa',
                'provider'=>'Chapa',
                'is_active'=>true,
            ],

            [
                'name'=>'Telebirr',
                'provider'=>'Telebirr',
                'is_active'=>true,
            ],

            [
                'name'=>'CBE Birr',
                'provider'=>'CBE',
                'is_active'=>true,
            ],

        ]);

    }
}