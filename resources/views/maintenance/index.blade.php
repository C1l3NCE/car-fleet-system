@extends('layouts.app')
@php($title = '🛠 ТО и ремонт')
@section('title', 'ТО и ремонт')

@section('content')

<div class="container-fluid">

    {{-- 🔷 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <div class="text-muted small">
                {{ $vehicle->brand }} {{ $vehicle->model }} • {{ $vehicle->reg_number }}
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('vehicles.show', $vehicle) }}"
               class="btn btn-outline-secondary btn-sm">
                ← Назад
            </a>

            <a href="{{ route('maintenance.create', $vehicle) }}"
               class="btn btn-primary btn-sm">
                ➕ Добавить
            </a>
        </div>

    </div>


    @if($records->isEmpty())

        <div class="card card-modern p-4 text-center text-muted">
            Записей о техническом обслуживании пока нет
        </div>

    @else


        {{-- ===== ГРАФИК ===== --}}
        <div class="card card-modern p-4 mb-4">
            <h6 class="fw-semibold mb-3">
                📊 Стоимость обслуживания
            </h6>

            <div style="height:220px;">
                <canvas id="costChart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('costChart'), {
                type: 'bar',
                data: {
                    labels: @json($dates),
                    datasets: [{
                        data: @json($costs),
                        backgroundColor: '#2563eb',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        </script>


        {{-- ===== ИСТОРИЯ ===== --}}
        <div class="card card-modern p-4">

            <h6 class="fw-semibold mb-3">
                История обслуживания
            </h6>

            {{-- Desktop --}}
            <div class="d-none d-md-block">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Дата</th>
                            <th>Тип</th>
                            <th>Пробег</th>
                            <th>Стоимость</th>
                            <th>Сервис</th>
                            <th>Комментарий</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $item)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->service_date)->format('d.m.Y') }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $item->type }}
                                </td>
                                <td>
                                    {{ number_format($item->odometer, 0, ',', ' ') }} км
                                </td>
                                <td class="fw-semibold">
                                    {{ number_format($item->cost, 0, ',', ' ') }} ₸
                                </td>
                                <td>
                                    {{ $item->service_center ?? '—' }}
                                </td>
                                <td>
                                    {{ $item->notes ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            {{-- Mobile --}}
            <div class="d-md-none">
                @foreach($records as $item)
                    <div class="border-bottom py-3 small">

                        <div class="d-flex justify-content-between">
                            <strong>{{ $item->type }}</strong>
                            <span class="text-muted">
                                {{ \Carbon\Carbon::parse($item->service_date)->format('d.m.Y') }}
                            </span>
                        </div>

                        <div class="mt-2">
                            {{ number_format($item->odometer, 0, ',', ' ') }} км •
                            <strong>{{ number_format($item->cost, 0, ',', ' ') }} ₸</strong>
                        </div>

                        <div class="text-muted">
                            Сервис: {{ $item->service_center ?? '—' }}
                        </div>

                        @if($item->notes)
                            <div class="text-muted mt-1">
                                {{ $item->notes }}
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

        </div>

    @endif

</div>

@endsection
