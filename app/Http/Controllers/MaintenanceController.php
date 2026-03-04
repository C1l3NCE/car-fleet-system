<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        $records = $vehicle->maintenances()->orderBy('service_date', 'desc')->get();

        $dates = $records->pluck('service_date');
        $costs = $records->pluck('cost');

        return view('maintenance.index', compact('vehicle', 'records', 'dates', 'costs'));
    }

    public function create(Vehicle $vehicle)
    {
        return view('maintenance.create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'odometer' => 'required|numeric',
            'cost' => 'nullable|numeric',
            'service_date' => 'required|date',
            'service_center' => 'nullable|string',
            'notes' => 'nullable|string',
            'next_service_date' => 'nullable|date',
            'next_service_odometer' => 'nullable|numeric',
        ]);

        $data['vehicle_id'] = $vehicle->id;

        Maintenance::create($data);

        return redirect()->route('maintenance.index', $vehicle)
            ->with('success', 'Обслуживание добавлено!');
    }
}
