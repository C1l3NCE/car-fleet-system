@extends('layouts.app')

@php($title = 'Редактировать машину')

@section('content')

<div class="container-fluid">

    <div class="card card-modern p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold mb-0">
                ✏️ Редактирование автомобиля
            </h4>

            <a href="{{ route('vehicles.index') }}"
               class="btn btn-outline-secondary btn-sm">
                ← Назад
            </a>
        </div>

        <form action="{{ route('vehicles.update', $vehicle) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- Левая колонка --}}
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label class="form-label small text-muted">Марка</label>
                        <input type="text"
                               name="brand"
                               class="form-control"
                               value="{{ $vehicle->brand }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Модель</label>
                        <input type="text"
                               name="model"
                               class="form-control"
                               value="{{ $vehicle->model }}"
                               required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Год</label>
                            <input type="number"
                                   name="year"
                                   class="form-control"
                                   value="{{ $vehicle->year }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small text-muted">Пробег</label>
                            <input type="number"
                                   name="mileage"
                                   class="form-control"
                                   value="{{ $vehicle->mileage }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Гос. номер</label>
                        <input type="text"
                               name="reg_number"
                               class="form-control"
                               value="{{ $vehicle->reg_number }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">VIN</label>
                        <input type="text"
                               name="vin"
                               class="form-control"
                               value="{{ $vehicle->vin }}">
                    </div>

                </div>


                {{-- Правая колонка --}}
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label class="form-label small text-muted">Тип</label>
                        <select name="type" class="form-select">
                            @foreach(['легковой','грузовой','автобус','спецтехника'] as $type)
                                <option value="{{ $type }}"
                                    {{ $vehicle->type == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Тип топлива</label>
                        <input type="text"
                               name="fuel_type"
                               class="form-control"
                               value="{{ $vehicle->fuel_type }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">
                            Закрепить за водителем
                        </label>
                        <select name="current_driver_id" class="form-select">
                            <option value="">Не закреплять</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}"
                                    {{ $vehicle->current_driver_id == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Фото --}}
                    <div class="mb-3">
                        <label class="form-label small text-muted">Фото машины</label>
                        <input type="file" name="photo" class="form-control">

                        @if($vehicle->photo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/'.$vehicle->photo) }}"
                                     class="rounded shadow-sm"
                                     style="max-width: 220px;">
                            </div>
                        @endif
                    </div>

                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('vehicles.index') }}"
                   class="btn btn-outline-secondary">
                    Отмена
                </a>

                <button class="btn btn-primary">
                    💾 Сохранить изменения
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
