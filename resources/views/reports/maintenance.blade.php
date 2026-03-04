@extends('layouts.app')

@section('title', 'Отчёт по затратам')
@php($title = 'Отчёт по затратам на автомобиль')

@section('content')

<div class="container-fluid">

    {{-- 🔷 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-semibold mb-0">
                📊 Отчёт по затратам
            </h4>
            <div class="text-muted small">
                {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->reg_number }}
            </div>
        </div>

        {{-- Экспорт --}}
        <x-report-export-buttons 
            pdfRoute="reports.maintenance.pdf"
            excelRoute="reports.maintenance.excel"
            :params="['vehicle_id' => $vehicle->id]"
        />

    </div>


    {{-- 🔽 Выбор автомобиля --}}
    <div class="card card-modern p-3 mb-4">
        <form method="GET" action="{{ route('reports.maintenance') }}">
            <label class="form-label small text-muted">
                Выберите автомобиль
            </label>

            <select name="vehicle_id"
                    class="form-select"
                    onchange="this.form.submit()">
                @foreach($vehicles as $v)
                    <option value="{{ $v->id }}"
                        {{ $v->id == $vehicle->id ? 'selected' : '' }}>
                        {{ $v->brand }} {{ $v->model }} ({{ $v->reg_number }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>


    {{-- 🔷 KPI блоки --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="text-muted small">ТО</div>
                <h5 class="fw-bold text-primary mb-0">
                    {{ number_format($maintenanceSum, 0, ',', ' ') }} ₸
                </h5>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="text-muted small">Ремонты</div>
                <h5 class="fw-bold text-danger mb-0">
                    {{ number_format($repairSum, 0, ',', ' ') }} ₸
                </h5>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="text-muted small">Заправки</div>
                <h5 class="fw-bold text-success mb-0">
                    {{ number_format($fuelSum, 0, ',', ' ') }} ₸
                </h5>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100 border-start border-4 border-dark">
                <div class="text-muted small">Общие затраты</div>
                <h5 class="fw-bold mb-0">
                    {{ number_format($total, 0, ',', ' ') }} ₸
                </h5>
            </div>
        </div>

    </div>


    {{-- 🔷 Диаграмма --}}
    <div class="card card-modern p-4">
        <h6 class="fw-semibold mb-3">
            Структура затрат
        </h6>

        <div style="height:260px;">
            <canvas id="costChart"></canvas>
        </div>
    </div>

</div>


{{-- 🔷 Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

new Chart(document.getElementById('costChart'), {
    type: 'doughnut',
    data: {
        labels: @json($labels),
        datasets: [{
            data: @json($values),
            backgroundColor: [
                '#2563eb',  // ТО
                '#dc2626',  // Ремонт
                '#16a34a'   // Топливо
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

</script>

@endsection
