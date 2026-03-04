@extends('layouts.app')

@php($title = 'Заправки')

@section('content')

<div class="container-fluid">

    {{-- 🔷 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-0">
                ⛽ Заправки
            </h4>
            <div class="text-muted small">
                {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->reg_number }}
            </div>
        </div>

        <a href="{{ route('fuel.create', $vehicle) }}"
           class="btn btn-primary btn-sm">
            ➕ Добавить
        </a>
    </div>


    {{-- ================= ГРАФИКИ ================= --}}
    @if(count($logs))

    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="card card-modern p-3">
                <h6 class="fw-semibold mb-3">⛽ Литры</h6>
                <canvas id="chartLiters" height="120"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-modern p-3">
                <h6 class="fw-semibold mb-3">📉 Расход (л/100 км)</h6>
                <canvas id="chartConsumption" height="120"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-modern p-3">
                <h6 class="fw-semibold mb-3">💰 Стоимость</h6>
                <canvas id="chartTotalCost" height="120"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-modern p-3">
                <h6 class="fw-semibold mb-3">🚗 Пробег</h6>
                <canvas id="chartOdometer" height="120"></canvas>
            </div>
        </div>

    </div>

    @else

        <div class="card card-modern p-4 text-center text-muted mb-4">
            Нет данных по заправкам
        </div>

    @endif


    {{-- ================= ИСТОРИЯ ================= --}}
    <div class="card card-modern p-4">

        <h5 class="fw-semibold mb-3">
            История заправок
        </h5>

        {{-- Desktop --}}
        <div class="d-none d-md-block">

            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Дата</th>
                        <th>Литры</th>
                        <th>Цена</th>
                        <th>Сумма</th>
                        <th>Пробег</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                            <td>{{ $log->liters }} л</td>
                            <td>{{ $log->price_per_liter }} ₸</td>
                            <td class="fw-semibold">{{ $log->total_cost }} ₸</td>
                            <td>{{ number_format($log->odometer, 0, ',', ' ') }} км</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{-- Mobile --}}
        <div class="d-md-none">

            @foreach($logs as $log)
                <div class="border-bottom py-3 small">
                    <div class="d-flex justify-content-between">
                        <strong>⛽ Заправка</strong>
                        <span class="text-muted">
                            {{ $log->created_at->format('d.m H:i') }}
                        </span>
                    </div>

                    <div class="mt-2">
                        {{ $log->liters }} л •
                        {{ $log->price_per_liter }} ₸ •
                        <strong>{{ $log->total_cost }} ₸</strong>
                    </div>

                    <div class="text-muted">
                        Пробег: {{ number_format($log->odometer, 0, ',', ' ') }} км
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</div>


{{-- ================= CHART.JS ================= --}}
@if(count($logs))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($dates);

const defaultOptions = {
    responsive: true,
    plugins: { legend: { display: false } },
    elements: {
        line: { tension: 0.3, borderWidth: 3 }
    }
};

new Chart(document.getElementById('chartLiters'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            data: @json($liters),
            borderColor: '#2563eb'
        }]
    },
    options: defaultOptions
});

new Chart(document.getElementById('chartConsumption'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            data: @json($consumption),
            borderColor: '#16a34a'
        }]
    },
    options: defaultOptions
});

new Chart(document.getElementById('chartTotalCost'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            data: @json($totals),
            borderColor: '#dc2626'
        }]
    },
    options: defaultOptions
});

new Chart(document.getElementById('chartOdometer'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            data: @json($odometer),
            borderColor: '#f59e0b'
        }]
    },
    options: defaultOptions
});
</script>
@endif

@endsection
