@extends('layouts.app')
@php($title = 'Новая заправка')
@section('title', 'Добавить заправку')

@section('content')

<div class="container-fluid">

    <div class="card card-modern p-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-semibold mb-0">
                    ⛽ Новая заправка
                </h5>
                <div class="text-muted small">
                    {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->reg_number }}
                </div>
            </div>

            <a href="{{ route('fuel.index', $vehicle) }}"
               class="btn btn-outline-secondary btn-sm">
                ← Назад
            </a>
        </div>

        <form action="{{ route('fuel.store', $vehicle) }}" method="POST">
            @csrf

            <div class="row g-4">

                <div class="col-md-4">
                    <label class="form-label small text-muted">
                        Литры
                    </label>
                    <input type="number"
                           step="0.01"
                           name="liters"
                           id="liters"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted">
                        Цена за литр (₸)
                    </label>
                    <input type="number"
                           step="0.01"
                           name="price_per_liter"
                           id="price"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted">
                        Пробег при заправке
                    </label>
                    <input type="number"
                           name="odometer"
                           class="form-control"
                           value="{{ $vehicle->mileage }}"
                           required>
                </div>

            </div>

            {{-- Итоговая сумма --}}
            <div class="mt-4 p-3 bg-light rounded small">
                <span class="text-muted">Итого:</span>
                <strong id="totalCost">0 ₸</strong>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('fuel.index', $vehicle) }}"
                   class="btn btn-outline-secondary">
                    Отмена
                </a>

                <button class="btn btn-primary">
                    💾 Сохранить
                </button>
            </div>

        </form>

    </div>

</div>


{{-- 🔢 Авто-подсчёт --}}
<script>
const litersInput = document.getElementById('liters');
const priceInput = document.getElementById('price');
const totalDisplay = document.getElementById('totalCost');

function calculateTotal() {
    const liters = parseFloat(litersInput.value) || 0;
    const price = parseFloat(priceInput.value) || 0;
    const total = liters * price;

    totalDisplay.textContent = total.toLocaleString('ru-RU') + ' ₸';
}

litersInput.addEventListener('input', calculateTotal);
priceInput.addEventListener('input', calculateTotal);
</script>

@endsection
