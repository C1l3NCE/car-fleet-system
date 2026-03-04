<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            VehicleSeeder::class,
            FuelLogSeeder::class,
            MaintenanceSeeder::class,
            RepairSeeder::class,
            TripSeeder::class,
        ]);
    }
}
