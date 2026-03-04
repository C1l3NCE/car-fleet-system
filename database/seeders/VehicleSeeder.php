<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            [
                'brand' => 'Toyota',
    'model' => 'Camry',
    'year' => 2020,
    'reg_number' => 'WSJ13901',
    'vin' => 'JTNB11HK203045678',
    'type' => 'легковой',
    'status' => 'in_service',
    'current_driver_id' => 3,
    'mileage' => 23000,
    'fuel_type' => 'АИ-95',
    'photo' => 'vehicles/camry.jpg',
            ],
            [
                'brand' => 'Hyundai',
    'model' => 'Tucson',
    'year' => 2017,
    'reg_number' => 'KMHJT81B0EU123456',
    'vin' => 'KMHJT81B0EU123456',
    'type' => 'легковой',
    'status' => 'in_service',
    'current_driver_id' => 4,
    'mileage' => 18000,
    'fuel_type' => 'АИ-95',
    'photo' => 'vehicles/tucson.jpg',
            ],
            [
                'brand' => 'ГАЗ',
    'model' => 'Газель Next',
    'year' => 2021,
    'reg_number' => '124ABC03',
    'vin' => 'XW8G0Next01234567',
    'type' => 'грузовой',
    'status' => 'in_service',
    'current_driver_id' => 5,
    'mileage' => 32000,
    'fuel_type' => 'ДТ',
    'photo' => 'vehicles/next.jpg',
            ],
            [
               'brand' => 'Mercedes',
    'model' => 'Sprinter',
    'year' => 2019,
    'reg_number' => '777QWE01',
    'vin' => 'WDB9066571S123456',
    'type' => 'автобус',
    'status' => 'in_service',
    'current_driver_id' => 6,
    'mileage' => 54000,
    'fuel_type' => 'ДТ',
    'photo' => 'vehicles/sprinter.webp',
            ],
        ];

        foreach ($vehicles as $v) {
            Vehicle::create($v);
        }
    }
}
