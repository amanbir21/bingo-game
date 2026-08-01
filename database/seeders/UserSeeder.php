<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Admin users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '0911000000',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);


        User::create([
            'name' => 'Game Manager',
            'email' => 'manager@gmail.com',
            'phone' => '0911000001',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);



        // Player users
        User::create([
            'name' => 'Abebe Kebede',
            'email' => 'abebe@gmail.com',
            'phone' => '0911000002',
            'password' => 'password',
            'role' => 'player',
            'is_active' => true,
        ]);


        User::create([
            'name' => 'Almaz Tesfaye',
            'email' => 'almaz@gmail.com',
            'phone' => '0911000003',
            'password' => 'password',
            'role' => 'player',
            'is_active' => true,
        ]);


        User::create([
            'name' => 'Daniel Bekele',
            'email' => 'daniel@gmail.com',
            'phone' => '0911000004',
            'password' => 'password',
            'role' => 'player',
            'is_active' => true,
        ]);


        User::create([
            'name' => 'Sara Ahmed',
            'email' => 'sara@gmail.com',
            'phone' => '0911000005',
            'password' => 'password',
            'role' => 'player',
            'is_active' => true,
        ]);


        User::create([
            'name' => 'Mekdes Alemu',
            'email' => 'mekdes@gmail.com',
            'phone' => '0911000006',
            'password' => 'password',
            'role' => 'player',
            'is_active' => true,
        ]);

    }
}