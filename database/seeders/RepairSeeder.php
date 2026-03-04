<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Repair;
use App\Models\Vehicle;
use Carbon\Carbon;

class RepairSeeder extends Seeder
{
    public function run()
    {
        $types = [
            'Замена тормозных колодок',
            'Ремонт подвески',
            'Замена аккумулятора',
            'Ремонт электропроводки',
        ];

        foreach (Vehicle::all() as $vehicle) {
            for ($i = 1; $i <= 2; $i++) {

                Repair::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => $types[array_rand($types)],
                    'odometer' => $vehicle->mileage - rand(1000, 20000),
                    'cost' => rand(10000, 90000),
                    'repair_date' => Carbon::now()->subDays(rand(20, 200)),
                    'notes' => 'Выполнен плановый ремонт',
                ]);
            }
        }
    }
}
