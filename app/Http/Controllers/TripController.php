<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TripController extends Controller
{
    public function index(Vehicle $vehicle, Request $request)
    {
        $query = $vehicle->trips()->orderBy('started_at', 'desc');

        if ($request->filled('date_from')) {
            $query->whereDate('started_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('started_at', '<=', $request->date_to);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        if ($request->filled('route')) {
            $query->where('route', 'LIKE', '%' . $request->route . '%');
        }

        $trips = $query->get();

        // 🔥 ДОБАВЛЯЕМ ЭТО ДЛЯ ПОКАЗА АКТИВНОЙ ПОЕЗДКИ
        $activeTrip = Trip::where('vehicle_id', $vehicle->id)
            ->where('driver_id', Auth::id())
            ->whereNull('finished_at')
            ->first();

        $chartLabels = $trips->pluck('started_at')->map(function ($d) {
            return $d ? \Carbon\Carbon::parse($d)->format('d.m') : null;
        });
        $chartDistance = $trips->pluck('distance');
        $chartCount = $trips->count();

        $totalDistance = $trips->sum('distance');
        $avgDistance = $trips->avg('distance');
        $maxDistance = $trips->max('distance');

        return view('trips.index', compact(
            'vehicle',
            'trips',
            'chartLabels',
            'chartDistance',
            'chartCount',
            'totalDistance',
            'avgDistance',
            'maxDistance',
            'activeTrip'       // ← ОБЯЗАТЕЛЬНО
        ));
    }

    /**
     * Создание поездки вручную (форма)
     */
    public function create(Vehicle $vehicle)
    {
        return view('trips.create', compact('vehicle'));
    }

    /**
     * Сохранение поездки вручную
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'route' => 'nullable|string|max:255',
            'start_odometer' => 'required|integer|min:0',
            'end_odometer' => 'required|integer|min:0|gte:start_odometer',
            'started_at' => 'required|date',
            'finished_at' => 'required|date|after_or_equal:started_at',
            'notes' => 'nullable|string',
        ]);

        $data['vehicle_id'] = $vehicle->id;
        $data['driver_id'] = Auth::id();
        $data['distance'] = $data['end_odometer'] - $data['start_odometer'];

        Trip::create($data);

        return redirect()->route('trips.index', $vehicle)
            ->with('success', 'Поездка добавлена!');
    }

    public function start(Vehicle $vehicle, Request $request)
    {
        // ❌ защита от двойной поездки
        $activeTrip = Trip::where('vehicle_id', $vehicle->id)
            ->where('driver_id', Auth::id())
            ->whereNull('finished_at')
            ->first();

        if ($activeTrip) {
            return back()->withErrors('Поездка уже активна');
        }

        // ✅ валидация ТОЛЬКО route
        $request->validate([
            'route' => 'nullable|string|max:255',
        ]);

        Trip::create([
            'vehicle_id' => $vehicle->id,
            'driver_id' => Auth::id(),
            'route' => $request->route ?? 'Поездка',
            'start_odometer' => $vehicle->mileage, // 🔥 ВАЖНО
            'started_at' => now(),
        ]);

        return redirect()
            ->route('trips.index', $vehicle)
            ->with('success', 'Поездка начата!');
    }

    public function finish(Trip $trip, Request $request)
    {
        $request->validate([
            'end_odometer' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($trip) {
                    if ($value < $trip->start_odometer) {
                        $fail('Пробег не может быть меньше стартового: ' . $trip->start_odometer . ' км');
                    }
                }
            ],
            'notes' => 'nullable|string|max:500',
        ]);

        $distance = $request->end_odometer - $trip->start_odometer;

        $trip->update([
            'end_odometer' => $request->end_odometer,
            'distance' => $distance,
            'finished_at' => now(),
            'notes' => $request->notes,
        ]);

        // 🔥 СИНХРОНИЗАЦИЯ ПРОБЕГА МАШИНЫ
        $trip->vehicle->update([
            'mileage' => $request->end_odometer,
        ]);

        if ($trip->driver_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('trips.index', ['vehicle' => $trip->vehicle_id])
            ->with('success', 'Поездка завершена! Пробег обновлён');
    }

    public function destroy(Trip $trip)
    {
        $vehicleId = $trip->vehicle_id;

        $trip->delete();

        return redirect()
            ->route('trips.index', $vehicleId)
            ->with('success', 'Поездка удалена!');
    }
}
