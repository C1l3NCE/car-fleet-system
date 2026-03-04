<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // -------------------- ОТЧЁТ ПО ЗАТРАТАМ --------------------

    public function maintenance(Request $request)
    {
        $vehicles = Vehicle::all();

        // Если машин нет
        if ($vehicles->count() == 0) {
            return view('reports.maintenance')->with([
                'vehicles' => [],
                'vehicle' => null,
                'fuelSum' => 0,
                'maintenanceSum' => 0,
                'repairSum' => 0,
                'total' => 0,
                'labels' => [],
                'values' => []
            ]);
        }

        // Корректный выбор машины
        $vehicleId = $request->vehicle_id ?? $vehicles->first()->id;
        $vehicle = Vehicle::find($vehicleId) ?? $vehicles->first();

        // Расчёты
        $fuelSum = $vehicle->fuelLogs()->sum('total_cost');
        $maintenanceSum = $vehicle->maintenances()->sum('cost');
        $repairSum = $vehicle->repairs()->sum('cost');
        $total = $fuelSum + $maintenanceSum + $repairSum;

        $labels = ['ТО', 'Ремонты', 'Топливо'];
        $values = [$maintenanceSum, $repairSum, $fuelSum];

        return view('reports.maintenance', compact(
            'vehicles',
            'vehicle',
            'fuelSum',
            'maintenanceSum',
            'repairSum',
            'total',
            'labels',
            'values'
        ));
    }

    public function maintenancePdf(Request $request)
    {
        $vehicle = Vehicle::find($request->vehicle_id);

        if (!$vehicle) {
            return back()->with('error', 'Автомобиль не найден');
        }

        $fuelSum = $vehicle->fuelLogs()->sum('total_cost');
        $maintenanceSum = $vehicle->maintenances()->sum('cost');
        $repairSum = $vehicle->repairs()->sum('cost');
        $total = $fuelSum + $maintenanceSum + $repairSum;

        $pdf = Pdf::loadView('reports.pdf.maintenance', compact(
            'vehicle', 'fuelSum', 'maintenanceSum', 'repairSum', 'total'
        ));

        return $pdf->download('report_'.$vehicle->id.'.pdf');
    }

    // -------------------- СПИСОК АВТОМОБИЛЕЙ --------------------

    public function vehicles()
    {
        $vehicles = Vehicle::with('driver')->get();
        return view('reports.vehicles', compact('vehicles'));
    }

    public function vehiclesPdf()
    {
        $vehicles = Vehicle::with('driver')->get();
        $pdf = Pdf::loadView('reports.pdf.vehicles', compact('vehicles'));
        return $pdf->download('vehicles.pdf');
    }

    // -------------------- ТРЕБУЮТ ТО --------------------

    public function needMaintenance()
    {
        $vehicles = Vehicle::all()->filter(function ($v) {
            $km = $v->remainingKm();
            $date = $v->nextServiceDate();
            return ($km !== null && $km < 500)
                || ($date && \Carbon\Carbon::parse($date)->isPast());
        });

        return view('reports.need_maintenance', compact('vehicles'));
    }

    public function needMaintenancePdf()
    {
        $vehicles = Vehicle::all()->filter(function ($v) {
            $km = $v->remainingKm();
            $date = $v->nextServiceDate();
            return ($km !== null && $km < 500)
                || ($date && \Carbon\Carbon::parse($date)->isPast());
        });

        $pdf = Pdf::loadView('reports.pdf.need_maintenance', compact('vehicles'));
        return $pdf->download('need_maintenance.pdf');
    }
}
