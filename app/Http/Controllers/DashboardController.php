<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Maintenance;
use Carbon\Carbon;
use App\Services\AIService;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {

            $lastLogs = ActivityLog::latest()->limit(5)->get();

            $usersCount = User::count();
            $vehiclesCount = Vehicle::count();
            $driversCount = User::where('role', 'driver')->count();

            // Машины с просроченным ТО
            $maintenanceCount = Vehicle::all()->filter(function ($v) {
                $date = $v->nextServiceDate();
                return $date && Carbon::parse($date)->isPast();
            })->count();

            return view('dashboard.admin', compact(
                'lastLogs',
                'usersCount',
                'vehiclesCount',
                'driversCount',
                'maintenanceCount'
            ));
        }

        if ($user->role === 'operator') {

            // Все машины
            $vehicles = Vehicle::all();

            // --- БАЗОВАЯ СТАТИСТИКА ---
            $totalVehicles = $vehicles->count();
            $activeDrivers = User::where('role', 'driver')->count();
            $vehiclesInUse = $vehicles->whereNotNull('current_driver_id')->count();

            // --- СОСТОЯНИЕ ТО ---
            $vehiclesNeedService = $vehicles->filter(function ($v) {
                $date = $v->nextServiceDate();
                return $date && Carbon::parse($date)->diffInDays(now(), false) <= 7;
            })->count();

            $vehiclesOverdue = $vehicles->filter(function ($v) {
                $date = $v->nextServiceDate();
                return $date && Carbon::parse($date)->isPast();
            })->count();

            // --- СТАТИСТИКА ТО ПО МЕСЯЦАМ ---
            $rawStats = Maintenance::selectRaw(
                'MONTH(service_date) as month, COUNT(*) as total'
            )
                ->whereYear('service_date', now()->year)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $maintenanceStats = collect(range(1, 12))->mapWithKeys(function ($month) use ($rawStats) {
                return [$month => $rawStats[$month] ?? 0];
            });

            // --- ПОСЛЕДНИЕ СОБЫТИЯ ---
            $operatorLogs = ActivityLog::whereIn('action', [
                'maintenance.create',
                'fuel.create',
                'repairs.create',
            ])->latest()->limit(5)->get();

            // --- 🤖 AI-РЕКОМЕНДАЦИЯ ---
            $aiRecommendation = AIService::operatorRecommendation($vehicles);

            // --- ПЕРЕДАЧА В ШАБЛОН ---
            return view('dashboard.operator', [
                'totalVehicles' => $totalVehicles,
                'activeDrivers' => $activeDrivers,
                'vehiclesInUse' => $vehiclesInUse,
                'vehiclesNeedService' => $vehiclesNeedService,
                'vehiclesOverdue' => $vehiclesOverdue,
                'maintenanceStats' => $maintenanceStats,
                'operatorLogs' => $operatorLogs,
                'aiRecommendation' => $aiRecommendation,
            ]);
        }


        if ($user->role === 'driver') {

            $vehicle = Vehicle::where('current_driver_id', $user->id)->first();

            if (!$vehicle) {
                return view('dashboard.driver', ['vehicle' => null]);
            }

            // Последнее ТО
            $lastMaintenance = $vehicle->maintenances()->orderByDesc('service_date')->first();

            // Следующее ТО
            $nextDate = $vehicle->nextServiceDate();
            $remainingKm = $vehicle->remainingKm();

            // Уведомления
            $alertMileage = $remainingKm !== null && $remainingKm < 1000;
            $alertDate = $nextDate !== null &&
                \Carbon\Carbon::parse($nextDate)->diffInDays(now(), false) >= -14;

            // Активная поездка
            $activeTrip = \App\Models\Trip::where('vehicle_id', $vehicle->id)
                ->where('driver_id', $user->id)
                ->whereNull('finished_at')
                ->first();

            // 🧠 AI-анализ автомобиля
            $ai = \App\Services\CarAI::analyze($vehicle);

            return view('dashboard.driver', compact(
                'vehicle',
                'lastMaintenance',
                'alertMileage',
                'alertDate',
                'activeTrip',
                'ai'  // ← ВАЖНО!
            ));
        }




    }
}
