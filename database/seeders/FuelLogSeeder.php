<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuelLog;
use App\Models\Vehicle;
use App\Models\User;

class FuelLogSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            for ($i = 1; $i <= 5; $i++) {

                $liters = rand(20, 60);
                $price = rand(180, 260);
                $total = $liters * $price;

                FuelLog::create([
                    'vehicle_id' => $vehicle->id,
                    'driver_id' => $vehicle->current_driver_id,
                    'liters' => $liters,
                    'price_per_liter' => $price,
                    'total_cost' => $total,
                    'odometer' => $vehicle->mileage - rand(1000, 5000),
                ]);
            }
        }
    }
}
