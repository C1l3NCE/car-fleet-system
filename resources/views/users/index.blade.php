@extends('layouts.app')

@php($title = 'Пользователи')
@section('title', 'Пользователи')

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1">👥 Пользователи</h2>
                <p class="text-muted mb-0">
                    Всего пользователей: <strong>{{ $users->count() }}</strong>
                </p>
            </div>

            <a href="{{ route('users.create') }}" class="btn btn-primary">
                ➕ Добавить пользователя
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Карточка --}}
        {{-- ===== DESKTOP ===== --}}
        <div class="card shadow-sm border-0 d-none d-md-block">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Пользователь</th>
                                <th>Email</th>
                                <th style="width: 220px;">Роль</th>
                                <th style="width: 150px;">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $u->id }}
                                        </span>
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $u->name }}
                                    </td>

                                    <td>
                                        <small class="text-muted">
                                            {{ $u->email }}
                                        </small>
                                    </td>

                                    <td>
                                        <form action="{{ route('users.updateRole', $u) }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            @method('PATCH')

                                            <select name="role" class="form-select form-select-sm">
                                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>🛡
                                                    Администратор</option>
                                                <option value="operator" {{ $u->role === 'operator' ? 'selected' : '' }}>📊
                                                    Оператор</option>
                                                <option value="driver" {{ $u->role === 'driver' ? 'selected' : '' }}>🚗 Водитель
                                                </option>
                                                <option value="mechanic" {{ $u->role === 'mechanic' ? 'selected' : '' }}>🔧
                                                    Механик</option>
                                            </select>
                                    </td>

                                    <td>
                                        <button class="btn btn-success btn-sm w-100">
                                            💾 Сохранить
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        {{-- ===== MOBILE ===== --}}
        <div class="d-md-none">

            @foreach($users as $u)
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <strong>{{ $u->name }}</strong>
                            <span class="badge bg-secondary">
                                #{{ $u->id }}
                            </span>
                        </div>

                        <div class="small text-muted mb-3">
                            {{ $u->email }}
                        </div>

                        <form action="{{ route('users.updateRole', $u) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <select name="role" class="form-select mb-2">
                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>🛡 Администратор</option>
                                <option value="operator" {{ $u->role === 'operator' ? 'selected' : '' }}>📊 Оператор</option>
                                <option value="driver" {{ $u->role === 'driver' ? 'selected' : '' }}>🚗 Водитель</option>
                                <option value="mechanic" {{ $u->role === 'mechanic' ? 'selected' : '' }}>🔧 Механик</option>
                            </select>

                            <button class="btn btn-success w-100">
                                💾 Сохранить
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

        </div>

    </div>

@endsection