@extends('layouts.app')

@section('title', $vehicle->brand.' '.$vehicle->model)

@section('content')

<div class="container-fluid">

    {{-- 🔷 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-0">
                {{ $vehicle->brand }} {{ $vehicle->model }}
            </h4>
            <div class="text-muted small">
                {{ $vehicle->reg_number }}
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('fuel.index', $vehicle) }}"
               class="btn btn-outline-secondary btn-sm">
                ⛽ Заправки
            </a>

            <a href="{{ route('vehicles.edit', $vehicle) }}"
               class="btn btn-warning btn-sm">
                ✏️ Редактировать
            </a>
        </div>
    </div>


    {{-- 🔷 Основная карточка --}}
    <div class="card card-modern mb-4 overflow-hidden">

        <div class="row g-0">

            {{-- Фото --}}
            <div class="col-lg-4" style="min-height:220px;">
                @if($vehicle->photo)
                    <img src="{{ asset('storage/'.$vehicle->photo) }}"
                         class="w-100 h-100"
                         style="object-fit: cover;">
                @else
                    <div class="h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                        Нет фото
                    </div>
                @endif
            </div>

            {{-- Информация --}}
            <div class="col-lg-8 p-4">

                <div class="row small">

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">Год выпуска</span><br>
                        <strong>{{ $vehicle->year }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">VIN</span><br>
                        <strong>{{ $vehicle->vin ?: '—' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">Пробег</span><br>
                        <strong>
                            {{ number_format($vehicle->mileage, 0, ',', ' ') }} км
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">Тип топлива</span><br>
                        <strong>{{ $vehicle->fuel_type ?: '—' }}</strong>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- 🔷 AI-Аналитика --}}
    @if(isset($aiAnalysis))

        <div class="card card-modern mb-4 p-4 border-start border-4 border-primary">

            <h5 class="fw-semibold mb-3">
                🤖 AI-анализ технического состояния
            </h5>

            @foreach(explode("\n", $aiAnalysis) as $line)
                <div class="small text-muted mb-1">
                    {{ $line }}
                </div>
            @endforeach

        </div>

    @endif

</div>

@endsection
