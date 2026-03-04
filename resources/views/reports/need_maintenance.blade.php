@extends('layouts.app')

@php($title = 'Автомобили, требующие ТО')
@section('title', 'Отчёт - Автомобили, требующие ТО')

@section('content')

<div class="container-fluid">

    {{-- 🔽 Экспорт --}}
    <div class="mb-3">
        <x-report-export-buttons 
            pdfRoute="reports.needMaintenance.pdf"
            excelRoute="reports.needMaintenance.excel"
        />
    </div>

    @if($vehicles->isEmpty())

        <div class="alert alert-success">
            🎉 Нет автомобилей, требующих обслуживания.
        </div>

    @else

        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Авто</th>
                            <th>Гос. номер</th>
                            <th>Остаток км</th>
                            <th>Дата ТО</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($vehicles as $v)
                            <tr>
                                <td class="text-muted">{{ $v->id }}</td>

                                <td class="fw-semibold">
                                    {{ $v->brand }} {{ $v->model }}
                                </td>

                                <td>{{ $v->reg_number }}</td>

                                <td>
                                    @if($v->remainingKm() !== null)
                                        {{ number_format($v->remainingKm(), 0, ',', ' ') }} км
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    @if($v->nextServiceDate())
                                        {{ \Carbon\Carbon::parse($v->nextServiceDate())->format('d.m.Y') }}
                                    @else
                                        —
                                    @endif
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
