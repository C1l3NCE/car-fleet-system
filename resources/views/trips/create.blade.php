@extends('layouts.app')

@section('title', 'Добавить поездку')

@section('content')
<h1>Добавить поездку</h1>

<form action="{{ route('trips.store', $vehicle) }}" method="POST" class="mt-4">
    @csrf

    <div class="mb-3">
        <label class="form-label">Маршрут / цель поездки</label>
        <input type="text" name="route" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Пробег (начало)</label>
        <input type="number" name="start_odometer" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Пробег (конец)</label>
        <input type="number" name="end_odometer" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Дата начала</label>
        <input type="datetime-local" name="started_at" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Дата окончания</label>
        <input type="datetime-local" name="finished_at" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Комментарий</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <button class="btn btn-success">Сохранить</button>
    <a href="{{ route('trips.index', $vehicle) }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
