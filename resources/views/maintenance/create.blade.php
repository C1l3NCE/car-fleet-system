@extends('layouts.app')
@php($title = '🛠 Новое обслуживание')
@section('title', 'Добавить обслуживание')

@section('content')

<div class="container-fluid">

    <div class="card card-modern p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="text-muted small">
                    {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->reg_number }}
                </div>
            </div>

            <a href="{{ route('maintenance.index', $vehicle) }}"
               class="btn btn-outline-secondary btn-sm">
                ← Назад
            </a>
        </div>

        <form action="{{ route('maintenance.store', $vehicle) }}" method="POST">
            @csrf

            {{-- ===== Текущее обслуживание ===== --}}
            <h6 class="fw-semibold mb-3">Текущее обслуживание</h6>

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label small text-muted">
                        Тип работ
                    </label>
                    <input type="text"
                           name="type"
                           class="form-control"
                           placeholder="Например: Замена масла"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted">
                        Пробег
                    </label>
                    <input type="number"
                           name="odometer"
                           class="form-control"
                           value="{{ $vehicle->mileage }}"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted">
                        Стоимость (₸)
                    </label>
                    <input type="number"
                           name="cost"
                           class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted">
                        Дата обслуживания
                    </label>
                    <input type="date"
                           name="service_date"
                           class="form-control"
                           value="{{ now()->format('Y-m-d') }}"
                           required>
                </div>

                <div class="col-md-8">
                    <label class="form-label small text-muted">
                        Сервисный центр
                    </label>
                    <input type="text"
                           name="service_center"
                           class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label small text-muted">
                        Комментарий
                    </label>
                    <textarea name="notes"
                              class="form-control"
                              rows="2"></textarea>
                </div>

            </div>

            <hr class="my-4">

            {{-- ===== Следующее ТО ===== --}}
            <h6 class="fw-semibold mb-3">План следующего ТО</h6>

            <div class="row g-4">

                <div class="col-md-6">
                    <label class="form-label small text-muted">
                        Следующее ТО — по дате
                    </label>
                    <input type="date"
                           name="next_service_date"
                           class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label small text-muted">
                        Следующее ТО — по пробегу
                    </label>
                    <input type="number"
                           name="next_service_odometer"
                           class="form-control">
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('maintenance.index', $vehicle) }}"
                   class="btn btn-outline-secondary">
                    Отмена
                </a>

                <button class="btn btn-success">
                    💾 Сохранить
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
