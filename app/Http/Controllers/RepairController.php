<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index(Vehicle $vehicle, Request $request)
{
    // Фильтры
    $query = $vehicle->repairs()->orderBy('repair_date', 'desc');

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('date_from')) {
        $query->where('repair_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->where('repair_date', '<=', $request->date_to);
    }

    if ($request->filled('min_cost')) {
        $query->where('cost', '>=', $request->min_cost);
    }

    if ($request->filled('max_cost')) {
        $query->where('cost', '<=', $request->max_cost);
    }

    $repairs = $query->get();

    // Графики
    $chartLabels = $repairs->pluck('repair_date')->map(fn($d) => date('d.m', strtotime($d)));
    $chartCosts = $repairs->pluck('cost');

    // Статистика
    $totalCost = $repairs->sum('cost');
    $avgCost = $repairs->avg('cost');
    $maxCost = $repairs->max('cost');
    $count = $repairs->count();

    return view('repairs.index', compact(
        'vehicle',
        'repairs',
        'chartLabels',
        'chartCosts',
        'totalCost',
        'avgCost',
        'maxCost',
        'count'
    ));
}

    public function create(Vehicle $vehicle)
    {
        return view('repairs.create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'odometer' => 'nullable|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'repair_date' => 'required|date',
            'service_center' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['vehicle_id'] = $vehicle->id;
        $data['performed_by'] = auth()->id();

        Repair::create($data);

        return redirect()->route('repairs.index', $vehicle)
            ->with('success', 'Ремонт добавлен');
    }
}
