<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    public function index(Vehicle $vehicle)
{
    $logs = $vehicle->fuelLogs()->orderBy('created_at')->get();

    // Обработка данных для графиков
    $dates = [];
    $liters = [];
    $prices = [];
    $totals = [];
    $odometer = [];
    $consumption = []; // л/100км

    $lastOdometer = null;

    foreach ($logs as $log) {
        $dates[] = $log->created_at->format('d.m');

        $liters[] = $log->liters;
        $prices[] = $log->price_per_liter;
        $totals[] = $log->total_cost;
        $odometer[] = $log->odometer;

        if ($lastOdometer) {
            $distance = $log->odometer - $lastOdometer;
            if ($distance > 0) {
                $consumption[] = round(($log->liters / $distance) * 100, 2);
            } else {
                $consumption[] = null;
            }
        } else {
            $consumption[] = null;
        }

        $lastOdometer = $log->odometer;
    }

    return view('fuel.index', compact(
        'vehicle', 'logs',
        'dates', 'liters', 'prices',
        'totals', 'odometer', 'consumption'
    ));
}


    public function create(Vehicle $vehicle)
    {
        return view('fuel.create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'liters' => 'required|numeric|min:1',
            'price_per_liter' => 'required|numeric|min:1',
            'odometer' => 'required|numeric|min:0',
        ]);

        $data['total_cost'] = $data['liters'] * $data['price_per_liter'];
        $data['vehicle_id'] = $vehicle->id;
        $data['driver_id'] = auth()->id();

        FuelLog::create($data);

        return redirect()->route('fuel.index', $vehicle)->with('success', 'Заправка добавлена');
    }
}
