<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\Vehicle;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    public function run()
    {
        foreach (Vehicle::all() as $vehicle) {
            for ($i = 1; $i <= 5; $i++) {

                $start = $vehicle->mileage - rand(500, 5000);
                $end = $start + rand(20, 400);

                Trip::create([
                    'vehicle_id' => $vehicle->id,
                    'driver_id' => $vehicle->current_driver_id,
                    'route' => 'Маршрут #' . $i,
                    'start_odometer' => $start,
                    'end_odometer' => $end,
                    'distance' => $end - $start,
                    'started_at' => Carbon::now()->subDays(rand(5, 30)),
                    'finished_at' => Carbon::now()->subDays(rand(1, 5)),
                    'notes' => 'Рабочая поездка'
                ]);
            }
        }
    }
}
