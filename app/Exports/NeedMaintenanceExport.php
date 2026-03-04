<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NeedMaintenanceExport implements FromView
{
    protected $vehicles;

    public function __construct($vehicles)
    {
        $this->vehicles = $vehicles;
    }

    public function view(): View
    {
        return view('reports.excel.need_maintenance', [
            'vehicles' => $this->vehicles
        ]);
    }
}
