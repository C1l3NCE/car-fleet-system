@extends('layouts.app')

@section('title', 'Добавить ремонт')

@section('content')

<h1>Добавить ремонт — {{ $vehicle->brand }} {{ $vehicle->model }}</h1>

<form method="POST" action="{{ route('repairs.store', $vehicle) }}" class="mt-4">
    @csrf

    <div class="mb-3">
        <label class="form-label">Тип ремонта</label>
        <input type="text" name="type" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Пробег</label>
        <input type="number" name="odometer" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Стоимость</label>
        <input type="number" name="cost" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Дата ремонта</label>
        <input type="date" name="repair_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Сервисный центр</label>
        <input type="text" name="service_center" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Комментарий</label>
        <textarea name="notes" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Сохранить</button>
    <a href="{{ route('repairs.index', $vehicle) }}" class="btn btn-secondary">Отмена</a>
</form>

@endsection
