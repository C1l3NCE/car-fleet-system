@extends('layouts.app')

@php($title = 'Поездки')

@section('title', 'Поездки — ' . $vehicle->brand . ' ' . $vehicle->model)

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-semibold mb-0">
                    🚗 {{ $vehicle->brand }} {{ $vehicle->model }}
                </h4>
                <div class="text-muted small">
                    Гос. номер: {{ $vehicle->reg_number }} • Пробег: {{ number_format($vehicle->mileage) }} км
                </div>
            </div>

            @if(!$activeTrip)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#startTripModal">
                    Начать поездку
                </button>
            @endif
        </div>


        {{-- Успех --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- Активная поездка --}}
        @if($activeTrip)
            <div class="card border-warning mb-4 p-4">
                <h5 class="mb-3">🟢 Активная поездка</h5>

                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Маршрут</small>
                        <div>{{ $activeTrip->route }}</div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Стартовый пробег</small>
                        <div>{{ $activeTrip->start_odometer }} км</div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Начата</small>
                        <div>{{ $activeTrip->started_at?->format('d.m.Y H:i') }}</div>
                    </div>
                </div>

                <hr>

                <form action="{{ route('trips.finish', $activeTrip) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Пробег при завершении</label>
                            <input type="number" name="end_odometer" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Комментарий</label>
                            <input type="text" name="notes" class="form-control">
                        </div>
                    </div>

                    <button class="btn btn-success mt-3">
                        Завершить поездку
                    </button>
                </form>
            </div>
        @endif


        {{-- Фильтр --}}
        <div class="card p-3 mb-4">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label small">Дата с</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Дата по</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Маршрут</label>
                    <input type="text" name="route" value="{{ request('route') }}" class="form-control">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-outline-primary w-100">
                        Фильтр
                    </button>
                </div>

            </form>
        </div>


        {{-- Статистика --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <small class="text-muted">Всего поездок</small>
                    <h4 class="mb-0">{{ $chartCount }}</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <small class="text-muted">Общий пробег</small>
                    <h4 class="mb-0">{{ number_format($totalDistance) }} км</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <small class="text-muted">Средняя</small>
                    <h4 class="mb-0">{{ round($avgDistance, 1) ?? 0 }} км</h4>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <small class="text-muted">Максимум</small>
                    <h4 class="mb-0">{{ $maxDistance ?? 0 }} км</h4>
                </div>
            </div>

        </div>


        {{-- График --}}
        <div class="card p-4 mb-4">
            <h5 class="mb-3">📈 Динамика расстояния</h5>
            <canvas id="distanceChart" height="100"></canvas>
        </div>


        {{-- Таблица --}}
        <div class="card p-4">
            <h5 class="mb-3">Журнал поездок</h5>

            @if($trips->isEmpty())
                <div class="text-muted">Поездок пока нет.</div>
            @else
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Дата</th>
                            <th>Маршрут</th>
                            <th>Начало</th>
                            <th>Конец</th>
                            <th>Расстояние</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                            <tr>
                                <td>{{ $trip->started_at?->format('d.m.Y H:i') }}</td>
                                <td>{{ $trip->route }}</td>
                                <td>{{ $trip->start_odometer }} км</td>
                                <td>{{ $trip->end_odometer ?? '—' }}</td>
                                <td>{{ $trip->distance ?? '—' }} км</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>

    </div>


    {{-- График --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('distanceChart'), {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Расстояние (км)',
                    data: @json($chartDistance),
                    borderColor: '#0d6efd',
                    borderWidth: 3,
                    tension: 0.3
                }]
            }
        });
    </script>


    {{-- Модалка старта --}}
    <div class="modal fade" id="startTripModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('trips.start', ['vehicle' => $vehicle->id]) }}"
                  method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Начать поездку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Маршрут</label>
                    <input type="text"
                           name="route"
                           class="form-control"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        🚗 Начать поездку
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection