@extends('layouts.app')

@section('title', 'Поездки')

@section('content')
<h1>Мои поездки</h1>

{{-- Если нет активной поездки --}}
@if(!$activeTrip)
<div class="card p-3 mb-3">
    <h4>Начать поездку</h4>

    <form action="{{ route('trips.start', $vehicle) }}" method="POST">
        @csrf

        <label class="form-label">Маршрут:</label>
        <input type="text" name="route" class="form-control mb-2">

        <label class="form-label">Текущий пробег:</label>
        <input type="number" name="start_odometer" class="form-control mb-3" required>

        <button class="btn btn-primary">Начать</button>
    </form>
</div>
@endif


{{-- Если поездка активна --}}
@if($activeTrip)
<div class="card p-3 mb-3">
    <h4>Активная поездка</h4>

    <p><b>Маршрут:</b> {{ $activeTrip->route }}</p>
    <p><b>Начата:</b> {{ $activeTrip->started_at }}</p>
    <p><b>Стартовый пробег:</b> {{ $activeTrip->start_odometer }} км</p>

    <form action="{{ route('trips.finish', $activeTrip) }}" method="POST">
        @csrf
        @method('PATCH')

        <label class="form-label">Пробег при завершении:</label>
        <input type="number" name="end_odometer" class="form-control mb-2" required>

        <label class="form-label">Комментарий:</label>
        <textarea name="notes" class="form-control mb-3"></textarea>

        <button class="btn btn-success">Завершить поездку</button>
    </form>
</div>
@endif

@endsection
