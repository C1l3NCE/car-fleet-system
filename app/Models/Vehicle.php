<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'reg_number',
        'vin',
        'type',
        'status',
        'current_driver_id',
        'mileage',
        'fuel_type',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'current_driver_id');
    }

    public function repairs()
{
    return $this->hasMany(Repair::class);
}

public function trips()
{
    return $this->hasMany(Trip::class);
}

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function nextMaintenance()
{
    return $this->maintenances()
        ->orderByDesc('service_date')
        ->first();
}

public function remainingKm()
{
    $m = $this->nextMaintenance();
    if (!$m || !$m->next_service_odometer) return null;

    return $m->next_service_odometer - $this->mileage;
}

public function nextServiceDate()
{
    $m = $this->nextMaintenance();
    return $m?->next_service_date;
}

}

