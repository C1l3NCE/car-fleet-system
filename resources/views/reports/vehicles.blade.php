@extends('layouts.app')

@php($title = 'Список автомобилей')
@section('title', 'Отчёт - Список автомобилей')

@section('content')

<div class="container-fluid">

    {{-- 🔽 Экспорт --}}
    <div class="mb-3">
        <x-report-export-buttons 
            pdfRoute="reports.vehicles.pdf"
            excelRoute="reports.vehicles.excel"
        />
    </div>

    @if($vehicles->isEmpty())

        <div class="alert alert-info">
            Автомобили отсутствуют.
        </div>

    @else

        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Марка</th>
                            <th>Модель</th>
                            <th>Гос. номер</th>
                            <th>Водитель</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($vehicles as $v)
                            <tr>
                                <td class="text-muted">{{ $v->id }}</td>

                                <td class="fw-semibold">
                                    {{ $v->brand }}
                                </td>

                                <td>
                                    {{ $v->model }}
                                </td>

                                <td>
                                    {{ $v->reg_number }}
                                </td>

                                <td>
                                    {{ $v->driver->name ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    @endif

</div>

@endsection
