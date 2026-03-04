<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AIService;

class VehicleController extends Controller
{
    public function index()
{
    $vehicles = Vehicle::all();

    foreach ($vehicles as $v) {
        $v->aiStatus = \App\Services\AIService::quickStatus($v);
    }

    return view('vehicles.index', compact('vehicles'));
}

    public function create()
    {
        $drivers = User::where('role','driver')->get();
        return view('vehicles.create', compact('drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Загрузка фото
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('vehicles', 'public');
            $data['photo'] = $path;
        }

        Vehicle::create($data);

        return redirect()->route('vehicles.index')->with('success', 'Машина добавлена');
    }

    public function show(Vehicle $vehicle)
    {
        $aiAnalysis = AIService::analyzeVehicle($vehicle);

        return view('vehicles.show', compact('vehicle', 'aiAnalysis'));
    }

    public function edit(Vehicle $vehicle)
    {
        $drivers = User::where('role','driver')->get();
        return view('vehicles.edit', compact('vehicle','drivers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->all();

        // Загрузка нового фото (если выбрано)
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('vehicles', 'public');
            $data['photo'] = $path;
        }

        $vehicle->update($data);

        return redirect()->route('vehicles.index')->with('success', 'Данные обновлены');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Машина удалена');
    }
}
