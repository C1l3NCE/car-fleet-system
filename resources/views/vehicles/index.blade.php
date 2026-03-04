@extends('layouts.app')
@php($title = 'Автопарк')
@section('title', 'Автопарк')

@section('content')

<div class="container-fluid">

    {{-- 🔷 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Автопарк</h4>

        <div class="d-flex gap-2">

            <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm" onclick="setView('cards')">
                    🧩
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setView('table')">
                    📋
                </button>
            </div>

            <a href="{{ route('vehicles.create') }}"
               class="btn btn-primary btn-sm">
                ➕ Добавить машину
            </a>
        </div>
    </div>


    {{-- ================= CARDS VIEW ================= --}}
    <div id="cardsView" class="row g-4">

        @foreach($vehicles as $vehicle)

            <div class="col-md-6 col-xl-4">

                <div class="card card-modern h-100 overflow-hidden">

                    {{-- Фото --}}
                    <div style="height:160px; background:#f8f9fa;">
                        @if($vehicle->photo)
                            <img src="{{ asset('storage/' . $vehicle->photo) }}"
                                 class="w-100 h-100"
                                 style="object-fit:cover;">
                        @else
                            <div class="d-flex h-100 align-items-center justify-content-center text-muted small">
                                Нет фото
                            </div>
                        @endif
                    </div>

                    {{-- Контент --}}
                    <div class="p-3">

                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-0">
                                    {{ $vehicle->brand }} {{ $vehicle->model }}
                                </h6>
                                <div class="text-muted small">
                                    {{ $vehicle->reg_number }}
                                </div>
                            </div>

                            {{-- Статус --}}
                            @if($vehicle->current_driver_id)
                                <span class="badge bg-success-subtle text-success">
                                    В эксплуатации
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary">
                                    Свободна
                                </span>
                            @endif
                        </div>

                        <div class="small text-muted mb-2">
                            Тип: <strong class="text-dark">{{ $vehicle->type }}</strong>
                            • Пробег:
                            <strong class="text-dark">
                                {{ number_format($vehicle->mileage, 0, ',', ' ') }} км
                            </strong>
                        </div>

                        <div class="small text-muted mb-3">
                            Водитель:
                            <strong class="text-dark">
                                {{ $vehicle->driver->name ?? '—' }}
                            </strong>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('vehicles.show', $vehicle) }}"
                               class="btn btn-outline-primary btn-sm">
                                Открыть
                            </a>

                            <a href="{{ route('vehicles.edit', $vehicle) }}"
                               class="btn btn-outline-secondary btn-sm">
                                ✏️
                            </a>

                            <a href="{{ route('fuel.index', $vehicle) }}"
                               class="btn btn-outline-secondary btn-sm">
                                ⛽
                            </a>

                            <a href="{{ route('maintenance.index', $vehicle) }}"
                               class="btn btn-outline-secondary btn-sm">
                                🛠
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    {{-- ================= TABLE VIEW ================= --}}
    <div id="tableView" class="d-none">

        <div class="card card-modern p-3">

            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Авто</th>
                        <th>Номер</th>
                        <th>Тип</th>
                        <th>Пробег</th>
                        <th>Водитель</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td class="fw-semibold">
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                            </td>
                            <td>{{ $vehicle->reg_number }}</td>
                            <td>{{ $vehicle->type }}</td>
                            <td>
                                {{ number_format($vehicle->mileage, 0, ',', ' ') }} км
                            </td>
                            <td>{{ $vehicle->driver->name ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('vehicles.show', $vehicle) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Открыть →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- ================= JS ================= --}}
<script>
function setView(view) {
    localStorage.setItem('vehicleView', view);
    applyView();
}

function applyView() {
    const view = localStorage.getItem('vehicleView') || 'cards';
    document.getElementById('cardsView').classList.toggle('d-none', view !== 'cards');
    document.getElementById('tableView').classList.toggle('d-none', view !== 'table');
}

document.addEventListener('DOMContentLoaded', applyView);
</script>

@endsection
