<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'vehicle_id',
        'performed_by',
        'type',
        'odometer',
        'cost',
        'repair_date',
        'service_center',
        'notes',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
