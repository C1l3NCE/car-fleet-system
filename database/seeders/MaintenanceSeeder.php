<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Carbon\Carbon;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $types = ['ТО-1', 'ТО-2', 'Замена масла', 'Диагностика'];

        foreach (Vehicle::all() as $vehicle) {
            for ($i = 1; $i <= 3; $i++) {
                Maintenance::create([
                    'vehicle_id' => $vehicle->id,
                    'type' => $types[array_rand($types)],
                    'odometer' => $vehicle->mileage - rand(2000, 15000),
                    'cost' => rand(15000, 60000),
                    'service_date' => Carbon::now()->subMonths(rand(1, 12)),
                    'service_center' => 'СТО №' . rand(1, 5),
                    'notes' => 'Плановое обслуживание',
                    'next_service_date' => Carbon::now()->addMonths(rand(3, 12)),
                    'next_service_odometer' => $vehicle->mileage + rand(5000, 15000),
                ]);
            }
        }
    }
}
