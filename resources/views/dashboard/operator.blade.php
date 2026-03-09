@extends('layouts.app')

@php($title = 'Панель оператора')
@section('title', 'Панель оператора')

@section('content')

    <div class="container-fluid">

        {{-- ================= KPI ================= --}}
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Всего автомобилей</div>
                            <h2 class="fw-bold mb-0">{{ $totalVehicles }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-truck fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Активные водители</div>
                            <h2 class="fw-bold mb-0">{{ $activeDrivers }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-person-badge fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Авто в эксплуатации</div>
                            <h2 class="fw-bold mb-0">{{ $vehiclesInUse }}</h2>
                        </div>
                        <div class="bg-dark bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-speedometer2 fs-3 text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- ================= ТО СТАТУС ================= --}}
        <div class="row g-4 mb-4">

            <div class="col-md-6">
                <div class="card card-modern p-4 border-start border-4 border-warning">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Скоро ТО (7 дней)</div>
                            <h2 class="fw-bold text-warning mb-0">
                                {{ $vehiclesNeedService }}
                            </h2>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-2 text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-modern p-4 border-start border-4 border-danger">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Просрочено ТО</div>
                            <h2 class="fw-bold text-danger mb-0">
                                {{ $vehiclesOverdue }}
                            </h2>
                        </div>
                        <i class="bi bi-x-octagon fs-2 text-danger"></i>
                    </div>
                </div>
            </div>

        </div>


        {{-- ================= AI ================= --}}
        @if(isset($aiRecommendation))
            <div class="card card-modern mb-4 p-4 bg-light border-start border-4 border-info">
                <h5 class="fw-semibold mb-2">
                    🤖 AI-анализ автопарка
                </h5>
                <p class="text-muted mb-0">
                    {{ $aiRecommendation }}
                </p>
            </div>
        @endif


        {{-- ================= ГРАФИК ================= --}}
        @if(isset($maintenanceStats))

            <div class="card card-modern mb-4 p-4">
                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-graph-up"></i>
                    ТО по месяцам ({{ now()->year }})
                </h5>

                @if($maintenanceStats->sum() == 0)
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-bar-chart-line fs-2 d-block mb-2"></i>
                        За {{ now()->year }} год данных по ТО пока нет
                    </div>
                @else
                    <canvas id="maintenanceChart" height="110"></canvas>
                @endif

            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const ctx = document.getElementById('maintenanceChart');
                    if (!ctx) return;

                    const labels = {!! json_encode(
                $maintenanceStats->keys()->map(
                    fn($m) =>
                    \Carbon\Carbon::create()->month($m)->translatedFormat('F')
                )
            ) !!};

                    const data = {!! json_encode($maintenanceStats->values()) !!};

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: 'rgba(37, 99, 235, 0.7)',
                                borderRadius: 8,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });

                });
            </script>
        @endif


        {{-- ================= СОБЫТИЯ ================= --}}
        @if(isset($operatorLogs))
            <div class="card card-modern mb-4 p-4">
                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-lightning-charge"></i>
                    Последние события
                </h5>

                @if($operatorLogs->isEmpty())
                    <p class="text-muted mb-0">Событий пока нет</p>
                @else
                    @foreach($operatorLogs as $log)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <div>
                                <span class="badge bg-secondary me-2">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <small class="text-muted">
                                {{ $log->created_at?->diffForHumans() }}
                            </small>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif


        {{-- ================= БЫСТРЫЕ ДЕЙСТВИЯ ================= --}}
        <div class="row g-4">

            <div class="col-md-6 col-xl-4">
                <div class="card card-modern p-4 h-100">
                    <h5 class="fw-semibold">
                        <i class="bi bi-truck"></i> Автомобили
                    </h5>
                    <p class="text-muted small">
                        Управление автопарком
                    </p>
                    <a href="{{ route('operator.vehicles') }}" class="btn btn-primary btn-sm mt-2">
                        Перейти →
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card card-modern p-4 h-100">
                    <h5 class="fw-semibold">
                        <i class="bi bi-clipboard-data"></i> Отчёты
                    </h5>
                    <p class="text-muted small">
                        Аналитика и контроль затрат
                    </p>
                    <a href="{{ route('reports.maintenance') }}" class="btn btn-success btn-sm mt-2">
                        Открыть →
                    </a>
                </div>
            </div>

        </div>

    </div>

@endsection