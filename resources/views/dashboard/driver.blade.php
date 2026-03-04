@extends('layouts.app')
@php($title = 'Мой автомобиль')
@section('title', 'Моя машина')

@section('content')

    <div class="container-fluid">

        {{-- 🔔 Уведомления --}}
        @if($alertMileage || $alertDate)
            <div class="card card-modern mb-4 border-start border-4 border-warning p-4">
                <h5 class="fw-semibold text-warning mb-2">
                    <i class="bi bi-exclamation-triangle"></i> Требуется внимание
                </h5>

                @if($alertMileage)
                    <div class="small text-muted">
                        🔧 До следующего ТО осталось
                        <strong>{{ $vehicle->remainingKm() }} км</strong>
                    </div>
                @endif

                @if($alertDate)
                    <div class="small text-muted">
                        📅 Следующее ТО:
                        <strong>{{ \Carbon\Carbon::parse($vehicle->nextServiceDate())->format('d.m.Y') }}</strong>
                    </div>
                @endif
            </div>
        @endif


        {{-- 🚗 Карточка автомобиля --}}
        <div class="card card-modern mb-4 p-3">

            <div class="d-flex align-items-center gap-4">

                {{-- Фото --}}
                <div style="width:120px; height:90px; flex-shrink:0;">
                    @if($vehicle->photo)
                        <img src="{{ asset('storage/' . $vehicle->photo) }}" class="w-100 h-100 rounded"
                            style="object-fit: cover;">
                    @else
                        <div
                            class="w-100 h-100 bg-light rounded d-flex align-items-center justify-content-center text-muted small">
                            Нет фото
                        </div>
                    @endif
                </div>

                {{-- Информация --}}
                <div class="flex-grow-1">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                            </h5>

                            <div class="small text-muted">
                                Гос. номер:
                                <strong class="text-dark">
                                    {{ $vehicle->reg_number }}
                                </strong>
                                • Пробег:
                                <strong class="text-dark">
                                    {{ $vehicle->mileage }} км
                                </strong>
                            </div>
                        </div>

                        {{-- Статус ТО --}}
                        @if($vehicle->nextServiceDate())
                            <div class="text-end small">
                                <div class="text-muted">Следующее ТО</div>
                                <div class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($vehicle->nextServiceDate())->format('d.m.Y') }}
                                </div>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>



        {{-- 🚀 Быстрые действия --}}
        <div class="card card-modern mb-4 p-4">
            <h5 class="fw-semibold mb-3">Быстрые действия</h5>

            <div class="d-grid gap-2 d-md-flex">

                <button type="button" class="btn btn-success w-100 w-md-auto" data-bs-toggle="modal"
                    data-bs-target="#startTripModal">
                    ➕ Начать поездку
                </button>

                <a href="{{ route('trips.index', $vehicle) }}" class="btn btn-outline-dark w-100 w-md-auto">
                    🚗 Мои поездки
                </a>

                <a href="{{ route('fuel.index', $vehicle) }}" class="btn btn-outline-primary w-100 w-md-auto">
                    ⛽ Заправки
                </a>

                <a href="{{ route('maintenance.index', $vehicle) }}" class="btn btn-outline-secondary w-100 w-md-auto">
                    🛠 История ТО
                </a>

            </div>
        </div>


        {{-- 🤖 AI --}}
        @if(isset($ai) && is_array($ai))
            <div class="card card-modern mb-4 p-4 border-start border-4 
                                            @if(($ai['risk'] ?? '') === 'high') border-danger
                                            @elseif(($ai['risk'] ?? '') === 'medium') border-warning
                                            @else border-success @endif">

                <h5 class="fw-semibold mb-2">
                    🤖 AI-анализ состояния
                </h5>

                <p class="small text-muted mb-1">
                    <strong>Статус:</strong> {{ $ai['status'] ?? '—' }}
                </p>

                <p class="small text-muted mb-0">
                    <strong>Рекомендация:</strong> {{ $ai['advice'] ?? '—' }}
                </p>
            </div>
        @endif


        {{-- 🔄 Активная поездка --}}
        @if($activeTrip)
            <div class="card card-modern mb-4 p-4 border-start border-4 border-warning">
                <h5 class="fw-semibold mb-3">
                    🚗 Активная поездка
                </h5>

                <div class="small text-muted mb-3">
                    Маршрут: <strong>{{ $activeTrip->route }}</strong><br>
                    Старт: {{ $activeTrip->start_odometer }} км
                </div>

                <form action="{{ route('trips.finish', $activeTrip) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <input type="number" name="end_odometer" class="form-control mb-2" placeholder="Пробег при завершении"
                        required>

                    <textarea name="notes" class="form-control mb-3" placeholder="Комментарий"></textarea>

                    <button class="btn btn-danger btn-sm">
                        🛑 Завершить поездку
                    </button>
                </form>
            </div>
        @endif


        {{-- 🛠 Последнее ТО --}}
        @if($lastMaintenance)
            <div class="card card-modern mb-4 p-4">
                <h5 class="fw-semibold mb-3">Последнее обслуживание</h5>

                <div class="row small">
                    <div class="col-md-6">Тип: <strong>{{ $lastMaintenance->type }}</strong></div>
                    <div class="col-md-6">Дата: {{ $lastMaintenance->service_date }}</div>
                    <div class="col-md-6 mt-2">Пробег: {{ $lastMaintenance->odometer }} км</div>
                    <div class="col-md-6 mt-2">Стоимость: {{ $lastMaintenance->cost }} ₸</div>
                </div>
            </div>
        @endif


        {{-- ⛽ Последние заправки --}}
        <div class="card card-modern p-4">
            <h5 class="fw-semibold mb-3">Последние заправки</h5>

            @foreach($vehicle->fuelLogs()->latest()->take(5)->get() as $log)
                <div class="d-flex justify-content-between border-bottom py-2 small">
                    <div>
                        {{ $log->created_at->format('d.m.Y') }}
                    </div>
                    <div>
                        {{ $log->liters }} л —
                        <strong>{{ $log->total_cost }} ₸</strong>
                    </div>
                </div>
            @endforeach

            <a href="{{ route('fuel.index', $vehicle) }}" class="btn btn-outline-primary btn-sm mt-3">
                Все заправки →
            </a>
        </div>

    </div>
    <div class="modal fade" id="startTripModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('trips.start', ['vehicle' => $vehicle->id]) }}" method="POST" class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Начать поездку</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label class="form-label">Маршрут</label>
                    <input type="text" name="route" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        🚗 Начать
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection