@extends('layouts.app')

@php($title = 'Журнал действий')

@section('content')


    {{-- ===== DESKTOP ===== --}}
    <div class="card shadow-sm border-0 d-none d-md-block">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Дата</th>
                            <th>Пользователь</th>
                            <th>Действие</th>
                            <th>Детали</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>

                                <td>
                                    {{ $log->user->name ?? 'Система' }}
                                </td>

                                <td>
                                    <code>{{ $log->action }}</code>
                                </td>

                                <td class="small text-muted">
                                    @if($log->details)
                                        {{ json_encode($log->details, JSON_UNESCAPED_UNICODE) }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $log->ip }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    {{-- ===== MOBILE ===== --}}
    <div class="d-md-none">

        @foreach($logs as $log)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">
                        <strong>
                            {{ $log->user->name ?? 'Система' }}
                        </strong>
                        <small class="text-muted">
                            {{ $log->created_at->format('d.m H:i') }}
                        </small>
                    </div>

                    <div class="mb-2">
                        <code>{{ $log->action }}</code>
                    </div>

                    <div class="small text-muted mb-2">
                        @if($log->details)
                            {{ json_encode($log->details, JSON_UNESCAPED_UNICODE) }}
                        @else
                            —
                        @endif
                    </div>

                    <div class="small">
                        <span class="text-muted">IP:</span>
                        {{ $log->ip }}
                    </div>

                </div>
            </div>
        @endforeach

    </div>

@endsection