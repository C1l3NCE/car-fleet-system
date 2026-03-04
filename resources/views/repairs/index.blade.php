@extends('layouts.app')

@section('title', 'Ремонты — ' . $vehicle->brand . ' ' . $vehicle->model)

@section('content')
    <h1 class="mb-4">Ремонты автомобиля {{ $vehicle->brand }} {{ $vehicle->model }}</h1>

    <a href="{{ route('repairs.create', $vehicle) }}" class="btn btn-primary mb-4">
        ➕ Добавить ремонт
    </a>

    {{-- Фильтры --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Фильтр</h5>
            <form method="GET">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Тип ремонта</label>
                        <input type="text" name="type" class="form-control" value="{{ request('type') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Дата от</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Дата до</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Мин. стоимость</label>
                        <input type="number" name="min_cost" class="form-control" value="{{ request('min_cost') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Макс. стоимость</label>
                        <input type="number" name="max_cost" class="form-control" value="{{ request('max_cost') }}">
                    </div>

                </div>

                <button class="btn btn-success mt-3">Применить</button>
                <a href="{{ route('repairs.index', $vehicle) }}" class="btn btn-secondary mt-3">Сбросить</a>
            </form>
        </div>
    </div>

    {{-- Статистика --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <strong>Всего ремонтов:</strong>
                <h3>{{ $count }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <strong>Общие затраты:</strong>
                <h3>{{ number_format($totalCost, 0, '.', ' ') }} ₸</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <strong>Средняя стоимость:</strong>
                <h3>{{ number_format($avgCost, 0, '.', ' ') }} ₸</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <strong>Максимальный ремонт:</strong>
                <h3>{{ number_format($maxCost, 0, '.', ' ') }} ₸</h3>
            </div>
        </div>
    </div>

    {{-- График затрат --}}
    <h3>График затрат</h3>
    <canvas id="chartCosts" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartCosts'), {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Стоимость ремонта',
                    data: @json($chartCosts),
                    borderColor: 'red',
                    borderWidth: 3,
                    tension: 0.3
                }]
            }
        });
    </script>

    {{-- Таблица ремонтов --}}
    <h3 class="mt-4">История ремонтов</h3>
    <table class="table table-bordered table-responsive-stack">

        <thead>
            <tr>
                <th>Дата</th>
                <th>Тип</th>
                <th>Пробег</th>
                <th>Стоимость</th>
                <th>Сервис</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>
            @foreach($repairs as $r)
                <tr>
                    <td>{{ $r->service_date }}</td>
                    <td>{{ $r->type }}</td>
                    <td>{{ $r->odometer }} км</td>
                    <td>{{ number_format($r->cost, 0, '.', ' ') }} ₸</td>
                    <td>{{ $r->service_center }}</td>
                    <td>{{ $r->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection