<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Админ
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Оператор
        User::create([
            'name' => 'Operator',
            'email' => 'operator@mail.com',
            'password' => Hash::make('password'),
            'role' => 'operator'
        ]);

        // Водители
        User::create([
            'name' => 'Driver Camry',
            'email' => 'driver_camry@mail.com',
            'password' => Hash::make('password'),
            'role' => 'driver'
        ]);

        User::create([
            'name' => 'Driver Tucson',
            'email' => 'driver_tucson@mail.com',
            'password' => Hash::make('password'),
            'role' => 'driver'
        ]);
        
        User::create([
            'name' => 'Driver Next',
            'email' => 'driver_next@mail.com',
            'password' => Hash::make('password'),
            'role' => 'driver'
        ]);

        User::create([
            'name' => 'Driver Sprinter',
            'email' => 'driver_sprinter@mail.com',
            'password' => Hash::make('password'),
            'role' => 'driver'
        ]);
    }
}
