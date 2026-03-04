<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'vehicle_id',
        'type',
        'odometer',
        'cost',
        'service_date',
        'service_center',
        'notes',
        'next_service_date',
        'next_service_odometer',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    
}
